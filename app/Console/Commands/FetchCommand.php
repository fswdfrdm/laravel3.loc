<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ApiService;
use App\Models\Stocks;
use App\Models\Incomes;
use App\Models\Sales;
use App\Models\Orders;

class FetchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch 
                            {controller? : Контроллер}
                            {dateFrom? : Дата от (Y-m-d)} 
                            {dateTo? : Дата до (Y-m-d)} 
                            {--page=1 : Номер страницы}
                            {--limit=100 : Лимит выборки}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Выгрузка данных в БД из API';

    // php artisan app:fetch stocks 2025-10-16 2024-10-09

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiService = new ApiService();

        $controller = $this->argument('controller');
        $dateFrom = $this->argument('dateFrom');
        $dateTo = $this->argument('dateTo');
        $page = $this->option('page');
        $limit = $this->option('limit');

        $this->info("Выборка $controller от $dateFrom до $dateTo (страница: $page, лимит: $limit)");

        $data = $apiService->fetch($controller, $dateFrom, $dateTo, $page, $limit);

        if ($data && $data['data']) {
            $this->processData($controller, $data['data']);
            $this->info('Успешная выгрузка в БД ' . count($data['data']) . ' элементов');
        } else {
            $this->error('Ошибка получения данных из API');

            if ($data) {
                $this->info('Данные от API: ' . json_encode($data));
            }
        }

    }

    private function processData($controller, $data)
    {
        $methodName = 'process' . ucfirst($controller);
        
        if (method_exists($this, $methodName)) {
            $this->$methodName($data);
        } else {
            $this->error("Метод обработки для контроллера '$controller' не найден");
        }
    }

    private function processStocks($data)
    {
        foreach ($data as $item) {
            try {
                Stocks::updateOrCreate(
                    [
                        'date' => $item['date'],
                        'last_change_date' => $item['last_change_date'],
                        'supplier_article' => $item['supplier_article'],
                        'tech_size' => $item['tech_size'],
                        'barcode' => $item['barcode'],
                        'quantity' => $item['quantity'],
                        'is_supply' => $item['is_supply'],
                        'is_realization' => $item['is_realization'],
                        'quantity_full' => $item['quantity_full'],
                        'warehouse_name' => $item['warehouse_name'],
                        'in_way_to_client' => $item['in_way_to_client'],
                        'in_way_from_client' => $item['in_way_from_client'],
                        'nm_id' => $item['nm_id'],
                        'subject' => $item['subject'],
                        'category' => $item['category'],
                        'brand' => $item['brand'],
                        'sc_code' => $item['sc_code'],
                        'price' => $item['price'],
                        'discount' => $item['discount']
                    ]
                );
            } catch (\Exception $e) {
                $this->error("Ошибка процесса выгрузки из stocks: " . $e->getMessage());
            }
        }
    }

    private function processIncomes($data)
    {
        foreach ($data as $item) {
            try {
                Incomes::updateOrCreate(
                    [
                        'income_id' => $item['income_id'],
                        'number' => $item['number'],
                        'date' => $item['date'],
                        'last_change_date' => $item['last_change_date'],
                        'supplier_article' => $item['supplier_article'],
                        'tech_size' => $item['tech_size'],
                        'barcode' => $item['barcode'],
                        'quantity' => $item['quantity'],
                        'total_price' => $item['total_price'],
                        'date_close' => $item['date_close'],
                        'warehouse_name' => $item['warehouse_name'],
                        'nm_id' => $item['nm_id']
                    ]
                );
            } catch (\Exception $e) {
                $this->error("Ошибка процесса выгрузки из incomes: " . $e->getMessage());
            }
        }
    }

    private function processSales($data)
    {
        foreach ($data as $item) {
            try {
                Sales::updateOrCreate(
                    [
                        'g_number' => $item['g_number'],
                        'date' => $item['date'],
                        'last_change_date' => $item['last_change_date'],
                        'supplier_article' => $item['supplier_article'],
                        'tech_size' => $item['tech_size'],
                        'barcode' => $item['barcode'],
                        'total_price' => $item['total_price'],
                        'discount_percent' => $item['discount_percent'],
                        'is_supply' => $item['is_supply'],
                        'is_realization' => $item['is_realization'],
                        'promo_code_discount' => $item['promo_code_discount'],
                        'warehouse_name' => $item['warehouse_name'],
                        'country_name' => $item['country_name'],
                        'oblast_okrug_name' => $item['oblast_okrug_name'],
                        'region_name' => $item['region_name'],
                        'income_id' => $item['income_id'],
                        'sale_id' => $item['sale_id'],
                        'odid' => $item['odid'],
                        'spp' => $item['spp'],
                        'for_pay' => $item['for_pay'],
                        'finished_price' => $item['finished_price'],
                        'price_with_disc' => $item['price_with_disc'],
                        'nm_id' => $item['nm_id'],
                        'subject' => $item['subject'],
                        'category' => $item['category'],
                        'brand' => $item['brand'],
                        'is_storno' => $item['is_storno']
                    ]
                );
            } catch (\Exception $e) {
                $this->error("Ошибка процесса выгрузки из sales: " . $e->getMessage());
            }
        }
    }

    private function processOrders($data)
    {
        foreach ($data as $item) {
            try {
                Orders::updateOrCreate(
                    [
                        'g_number' => $item['g_number'],
                        'date' => $item['date'],
                        'last_change_date' => $item['last_change_date'],
                        'supplier_article' => $item['supplier_article'],
                        'tech_size' => $item['tech_size'],
                        'barcode' => $item['barcode'],
                        'total_price' => $item['total_price'],
                        'discount_percent' => $item['discount_percent'],
                        'warehouse_name' => $item['warehouse_name'],
                        'oblast' => $item['oblast'],
                        'income_id' => $item['income_id'],
                        'odid' => $item['odid'],
                        'nm_id' => $item['nm_id'],
                        'subject' => $item['subject'],
                        'category' => $item['category'],
                        'brand' => $item['brand'],
                        'is_cancel' => $item['is_cancel'],
                        'cancel_dt' => $item['cancel_dt']
                    ]
                );
            } catch (\Exception $e) {
                $this->error("Ошибка процесса выгрузки из orders: " . $e->getMessage());
            }
        }
    }
}
