<?php

namespace Telefonica\Tests;

use Telefonica\Models\Actors\Company;
use Telefonica\Models\Actors\Business;
use Telefonica\Models\Actors\Person;
use Telefonica\Models\Actors\Business\Product;
use Telefonica\Models\Actors\Business\Collaborator;
use Telefonica\Models\Digital\Site;
use Telefonica\Models\Digital\Sitio;
use Telefonica\Models\Digital\Monitor;
use Telefonica\Models\Digital\MonitorIncident;
use Telefonica\Models\Digital\MonitorCheck;
use Telefonica\Models\Digital\Account;
use Telefonica\Models\Digital\Email;
use Telefonica\Models\Digital\Phone;
use Telefonica\Models\Crm\Lead;
use Telefonica\Models\Crm\LeadEvent;
use Telefonica\Models\Commercial\Package;
use Telefonica\Models\Commercial\Order;
use Telefonica\Models\Commercial\TimeEntry;

class TelefonicaTest extends TestCase
{
    public function test_company_and_business_creation()
    {
        $company = Company::create([
            'code' => 'empresa-teste',
            'name' => 'Empresa Teste',
            'status' => 'active',
            'position' => 1,
            'services' => ['dev', 'cloud'],
        ]);

        $this->assertDatabaseHas('companies', ['code' => 'empresa-teste']);
        $this->assertEquals('Empresa Teste', $company->name);
        $this->assertEquals(['dev', 'cloud'], $company->services);
        $this->assertTrue(Company::active()->where('code', 'empresa-teste')->exists());
    }

    public function test_company_hierarchy_parent_and_sub_companies()
    {
        $parent = Company::create([
            'code' => 'matriz',
            'name' => 'Holding Matriz',
            'status' => 'active',
        ]);

        $child = Company::create([
            'code' => 'filial-1',
            'name' => 'Filial Um',
            'parent_company_code' => 'matriz',
            'status' => 'active',
        ]);

        $this->assertEquals('Holding Matriz', $child->parentCompany->name);
        $this->assertCount(1, $parent->subCompanies);
        $this->assertEquals('filial-1', $parent->subCompanies->first()->code);
    }

    public function test_business_products_and_collaborators()
    {
        $company = Company::create([
            'code' => 'software-house',
            'name' => 'Software House',
        ]);

        $product = Product::create([
            'business_code' => 'software-house',
            'name' => 'SaaS ERP',
            'status' => 'active',
        ]);

        $collaborator = Collaborator::create([
            'business_code' => 'software-house',
            'name' => 'Dev Lead',
            'cpf' => '11122233344',
            'status' => 1,
        ]);

        $this->assertCount(1, $company->businessProducts);
        $this->assertEquals('SaaS ERP', $company->businessProducts->first()->name);
        $this->assertCount(1, $company->businessCollaborators);
        $this->assertEquals('Dev Lead', $company->businessCollaborators->first()->name);
    }

    public function test_site_and_sitio_creation()
    {
        $company = Company::create([
            'code' => 'tech-corp',
            'name' => 'Tech Corp',
        ]);

        $site = Site::create([
            'company_id' => $company->id,
            'slug' => 'techcorp.com.br',
            'name' => 'TechCorp Portal',
            'active' => true,
            'accepts_leads' => true,
            'category' => 'corporate',
            'position' => 2,
        ]);

        $this->assertDatabaseHas('sites', ['slug' => 'techcorp.com.br']);
        $this->assertEquals($company->id, $site->company_id);
        $this->assertTrue($site->active);
        $this->assertTrue(Site::category('corporate')->where('slug', 'techcorp.com.br')->exists());
        $this->assertTrue(Site::acceptingLeads()->where('slug', 'techcorp.com.br')->exists());
    }

    public function test_site_monitors_relationship()
    {
        $site = Site::create([
            'slug' => 'portal-monitorado.com.br',
            'name' => 'Portal Monitorado',
        ]);

        $monitor = Monitor::create([
            'site_id' => $site->id,
            'name' => 'Uptime Ping',
            'url' => 'https://portal-monitorado.com.br',
            'enabled' => true,
            'status' => 'no_ar',
        ]);

        $this->assertCount(1, $site->monitors);
        $this->assertEquals('Uptime Ping', $site->monitors->first()->name);
    }

    public function test_lead_and_lead_event_flow()
    {
        $site = Site::create([
            'slug' => 'portal.com.br',
            'name' => 'Portal',
        ]);

        $lead = Lead::create([
            'uuid' => '550e8400-e29b-41d4-a716-446655440000',
            'site_id' => $site->id,
            'name' => 'Cliente Teste',
            'email' => 'cliente@teste.com',
            'phone' => '11999999999',
            'status' => 'novo',
            'score' => 80,
            'step' => 1,
        ]);

        $this->assertDatabaseHas('leads', ['email' => 'cliente@teste.com']);

        $event = LeadEvent::create([
            'lead_id' => $lead->id,
            'type' => 'criado',
            'description' => 'Lead gerado via formulário',
            'meta' => ['ip' => '127.0.0.1'],
        ]);

        $this->assertDatabaseHas('lead_events', ['lead_id' => $lead->id]);
        $this->assertEquals($lead->id, $event->lead->id);
        $this->assertTrue(Lead::open()->where('uuid', '550e8400-e29b-41d4-a716-446655440000')->exists());
    }

    public function test_monitor_incidents_and_checks()
    {
        $site = Site::create([
            'slug' => 'monitoravel.com.br',
            'name' => 'Monitorável',
        ]);

        $monitor = Monitor::create([
            'site_id' => $site->id,
            'name' => 'HTTP Check',
            'url' => 'https://monitoravel.com.br',
            'enabled' => true,
            'status' => 'no_ar',
        ]);

        $this->assertDatabaseHas('monitors', ['url' => 'https://monitoravel.com.br']);
        $this->assertTrue(Monitor::active()->where('id', $monitor->id)->exists());

        $incident = MonitorIncident::create([
            'monitor_id' => $monitor->id,
            'started_at' => now()->subMinutes(10),
            'ended_at' => now(),
            'reason' => 'Timeout',
            'http_status' => 504,
        ]);

        $check = MonitorCheck::create([
            'monitor_id' => $monitor->id,
            'status' => 'no_ar',
            'http_status' => 200,
            'response_ms' => 120,
            'created_at' => now(),
        ]);

        $this->assertEquals($monitor->id, $incident->monitor->id);
        $this->assertEquals($monitor->id, $check->monitor->id);
        $this->assertCount(1, $monitor->incidents);
        $this->assertCount(1, $monitor->checks);
    }

    public function test_packages_orders_and_time_entries()
    {
        $site = Site::create([
            'slug' => 'vendas.com.br',
            'name' => 'Vendas',
        ]);

        $lead = Lead::create([
            'uuid' => '550e8400-e29b-41d4-a716-446655440001',
            'site_id' => $site->id,
            'name' => 'Comprador',
            'email' => 'comprador@teste.com',
            'status' => 'qualificado',
        ]);

        $package = Package::create([
            'name' => 'Plano Pro',
            'slug' => 'plano-pro',
            'setup_price' => 3000.00,
            'monthly_price' => 499.00,
            'features' => ['Suporte 24/7', 'SSL Incluso'],
            'is_active' => true,
            'highlight' => true,
        ]);

        $this->assertDatabaseHas('packages', ['slug' => 'plano-pro']);
        $this->assertTrue(Package::active()->where('slug', 'plano-pro')->exists());
        $this->assertTrue(Package::highlighted()->where('slug', 'plano-pro')->exists());

        $order = Order::create([
            'uuid' => 'ord-001',
            'lead_id' => $lead->id,
            'package_id' => $package->id,
            'setup_amount' => 3000.00,
            'monthly_amount' => 499.00,
            'payment_status' => 'pendente',
            'status' => Order::$STATUS_PENDING,
        ]);

        $this->assertDatabaseHas('orders', ['uuid' => 'ord-001']);
        $this->assertEquals($lead->id, $order->lead->id);
        $this->assertEquals($package->id, $order->package->id);
        $this->assertCount(1, $lead->orders);
        $this->assertCount(1, $package->orders);

        $timeEntry = TimeEntry::create([
            'order_id' => $order->id,
            'user_id' => 1,
            'worked_on' => now()->toDateString(),
            'hours' => 2.50,
            'description' => 'Configuração inicial do ambiente',
        ]);

        $this->assertDatabaseHas('time_entries', ['order_id' => $order->id]);
        $this->assertEquals($order->id, $timeEntry->order->id);
        $this->assertCount(1, $order->timeEntries);
    }

    public function test_person_model_creation()
    {
        $person = Person::create([
            'name' => 'João da Silva',
            'email' => 'joao@silva.com',
            'cpf' => '12345678901',
        ]);

        $this->assertDatabaseHas('persons', ['name' => 'João da Silva']);
        $this->assertEquals('João da Silva', $person->name);
    }

    public function test_email_and_phone_models()
    {
        $email = Email::create([
            'email' => 'contato@empresa.com.br',
            'address' => 'contato',
            'domain' => 'empresa.com.br',
        ]);

        $this->assertDatabaseHas('emails', ['email' => 'contato@empresa.com.br']);
        $this->assertEquals('empresa.com.br', $email->domain);

        $phone = Phone::create([
            'country' => '55',
            'state' => '11',
            'number' => '988887777',
            'whatsapp' => 1,
        ]);

        $this->assertDatabaseHas('phones', ['number' => '988887777']);
        $this->assertEquals('55', $phone->country);
    }

    public function test_infrastructure_and_growth_models()
    {
        $server = \Telefonica\Models\Infrastructure\Server::create([
            'name' => 'oci-prod-1',
            'provider' => 'oracle',
            'ip' => '129.148.25.10',
            'status' => 'ativo',
        ]);
        $this->assertDatabaseHas('servers', ['name' => 'oci-prod-1']);

        $serviceAccount = \Telefonica\Models\Infrastructure\ServiceAccount::create([
            'service_name' => 'Central Sync Token',
            'account_identifier' => 'central-api',
            'purpose' => 'api',
            'status' => 'active',
        ]);
        $this->assertDatabaseHas('service_accounts', ['service_name' => 'Central Sync Token']);
        $this->assertTrue(\Telefonica\Models\Infrastructure\ServiceAccount::service('Central Sync Token')->active()->exists());

        $site = Site::create([
            'slug' => 'growth-site.com.br',
            'name' => 'Growth Site',
        ]);

        $lead = Lead::create([
            'uuid' => '550e8400-e29b-41d4-a716-446655440099',
            'site_id' => $site->id,
            'name' => 'Lead Client',
            'email' => 'cliente@corp.com',
            'status' => 'qualificado',
        ]);

        $clientAccount = \Telefonica\Models\Commercial\ClientAccount::create([
            'uuid' => 'cl-001',
            'lead_id' => $lead->id,
            'email' => 'cliente@corp.com',
            'name' => 'Cliente Corp',
        ]);
        $this->assertDatabaseHas('client_accounts', ['uuid' => 'cl-001']);
        $this->assertEquals($lead->id, $clientAccount->lead->id);

        $project = \Telefonica\Models\Commercial\SiteProject::create([
            'uuid' => 'proj-001',
            'client_account_id' => $clientAccount->id,
            'domain' => 'site-cliente.com.br',
            'status' => 'aguardando_acesso',
        ]);
        $this->assertDatabaseHas('site_projects', ['uuid' => 'proj-001']);
        $this->assertEquals($clientAccount->id, $project->clientAccount->id);

        $message = \Telefonica\Models\Commercial\OutboundMessage::create([
            'channel' => 'whatsapp',
            'to' => '5511999998888',
            'body' => 'Olá! Seu pedido foi confirmado.',
            'status' => 'enviado',
        ]);
        $this->assertDatabaseHas('outbound_messages', ['channel' => 'whatsapp']);
        $this->assertStringContainsString('5511999998888', $message->manualUrl());

        $pageview = \Telefonica\Models\Digital\SitePageview::create([
            'site_id' => $site->id,
            'day' => now()->toDateString(),
            'path' => '/contato',
            'views' => 42,
        ]);
        $this->assertDatabaseHas('site_pageviews', ['path' => '/contato']);

        $funnel = \Telefonica\Models\Digital\FunnelVisit::create([
            'uuid' => 'funnel-001',
            'lead_id' => $lead->id,
            'landing_url' => 'https://growth-site.com.br/checkout',
            'channel' => 'web',
        ]);
        $this->assertDatabaseHas('funnel_visits', ['uuid' => 'funnel-001']);
        $this->assertEquals($lead->id, $funnel->lead->id);
    }
}

