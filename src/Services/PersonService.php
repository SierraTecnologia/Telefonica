<?php

namespace Telefonica\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Informate\Models\Refund;
use SierraTecnologia\Crypto\Services\Crypto;
use Telefonica\Repositories\PersonRepository;
use Telefonica\Models\Actors\Person;
use Muleta\Utils\Modificators\StringModificator;

class PersonService
{
    public function __construct(
        PersonRepository $personRepository
    ) {
        $this->repo = $personRepository;
    }

    /**
     * @todo Terminar de Fazer
     *  "Nome Artístico/ apelido" => ""                                                                                                                                                                                                             
  "Nome Completo" => "Paulo Gonçalves Júnior "                                                                                                                                                                                                
  "Nascimento " => "01/07/1988"                                                                                                                                                                                                               
  "Idade" => "32 anos "                                                                                                                                                                                                                       
  "Sexo / Identificação de Gênero" => "Masculino"                                                                                                                                                                                             
  "Endereço Completo" => "Rua Mercúrio 479 Casa 1"                                                                                                                                                                                            
  "Bairro" => "Pavuna "                                                                                                                                                                                                                       
  "Cidade" => "Rio de Janeiro "                                                                                                                                                                                                               
  "Telefone que mais usa" => "21982899701"                                                                                                                                                                                                    
  "Profissão" => "Produtor Cultural e Dançarino"                                                                                                                                                                                              
  "Grau de Escolaridade" => "Segundo Grau Completo (5ª a 3ºano)"                                                                                                                                                                              
  "Curso técnico? " => " Gestão Cultural Pela Instituição Idea e Produção Cultural Pela Produtora Burburinho Cultural  ( Em Andamento)"                                                                                                       
  "Fala Inglês?" => "Entendo um Pouco"                                                                                                                                                                                                        
  "Fala Espanhol?" => "Entendo um Pouco"                                                                                                                                                                                                      
  "Fala Francês?" => "Nada"                                                                                                                                                                                                                   
  "Fala Alemão?" => "Nada"                                                                                                                                                                                                                    
  "Você tem DRT? " => "Não "                                                                                                                                                                                                                  
  " RG" => "21.551.582-6"                                                                                                                                                                                                                     
  "CPF" => "133.546.337-27"                                                                                                                                                                                                                   
  "Você tem MEI? " => "Não "                                                                                                                                                                                                                  
  "Agência e conta" => "Agência:0001 Conta Corrente: 20939021-8  Banco: Nubank "                                                                                                                                                              
  " PIX" => "Pix: 133.546.337-27"
  "Cargos na RUA?" => "Produção Executiva, Dançarina(o)"
  "Peso?" => "80 kg"
  "Calça?" => "Tamanho G"
  " Blusa?" => "Tamanho G"
  "Altura?" => "1.68"
  "Nº sapato?" => "Numeração  40"
  "Redes Sociais." => "Estou no Instagram como @lilp_king. Instale o aplicativo para seguir minhas fotos e vídeos. https://www.instagram.com/invites/contact/?i=g0zjwr5kwk4h&utm_content=wedbxz"
     *
     * @return true
     */
    public static function import($data): bool
    {   
        $registerData = [];
        if (isset($data['Nome'])) {
            $registerData['name'] = $data["Nome"];
        }
        if (isset($data['Nome Completo'])) {
            $registerData['name'] = $data["Nome Completo"];
        }
        if (isset($data['CPF'])) {
            $registerData['cpf'] = $data["CPF"];
        }
        if (isset($data['Nascimento'])) {
            $registerData['birthday'] = $data["Nascimento"];
        }
        $code = $registerData['code'] = StringModificator::cleanCodeSlug($registerData['name']);

        if (\Telefonica\Models\Actors\Person::find($code)) {
            return true;
        }
        $person = Person::createIfNotExistAndReturn($registerData);
        return true;
    }

    /**
     * Get all Persons.
     *
     * @return Collection
     */
    public function all()
    {
        return $this->repo->all();
    }

    /**
     * Get all Persons.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginated()
    {
        return $this->repo->paginated(\Illuminate\Support\Facades\Config::get('siravel.pagination', 25));
    }

    /**
     * Find the Person by ID.
     *
     * @param int $id
     *
     * @return Persons
     */
    public function find($id)
    {
        return $this->repo->find($id);
    }

    /**
     * Search the orders.
     *
     * @param array $payload
     *
     * @return Collection
     */
    public function search($payload)
    {
        return $this->repo->search($payload, \Illuminate\Support\Facades\Config::get('siravel.pagination', 25));
    }

    /**
     * Create an order.
     *
     * @param array $payload
     *
     * @return Persons
     */
    public function create($payload)
    {
        $order = $this->repo->store($payload);

        $this->logistics->orderCreated($order);

        return $order;
    }

    /**
     * Update an order.
     *
     * @param int   $id
     * @param array $payload
     *
     * @return Persons
     */
    public function update($id, $payload)
    {
        $order = $this->find($id);

        if (isset($payload['is_shipped']) && $payload['is_shipped'] !== false) {
            $this->logistics->shipPerson($order);
        }

        return $this->repo->update($order, $payload);
    }

    /**
     * Cancel an order.
     *
     * @param int $id
     *
     * @return Persons|false
     */
    public function cancel($orderId)
    {
        $order = $this->repo->find($orderId);

        if ($order->status != 'complete') {
            $this->logistics->cancelPerson($order);

            if ($order->hasActivePersonItems()) {
                $refund = $this->transactions->refund($order->transaction('uuid'), $order->remainingValue());

                if ($refund) {
                    $refundRecord = app(Refund::class)->create(
                        [
                        'transaction_id' => $order->transaction('id'),
                        'provider_id' => $refund->id,
                        'uuid' => Crypto::uuid(),
                        'amount' => $refund->amount,
                        'provider' => 'SierraTecnologia',
                        'charge' => $refund->charge,
                        'currency' => $refund->currency,
                        ]
                    );

                    foreach ($order->items as $item) {
                        $item->update(
                            [
                            'was_refunded' => true,
                            'status' => 'cancelled',
                            'refund_id' => $refundRecord->id,
                            ]
                        );
                    }

                    return $this->update(
                        $order->id,
                        [
                        'status' => 'cancelled',
                        'is_shipped' => false,
                        ]
                    );
                }
            }
        }

        return false;
    }
}
