some important endpoints
/auth/users
/auth/menu
/auth/permisions


but i created everything as u see all in controller but i wonder as you logged in as admin i only see a dshboard but other menu are absent?

check ur databasese... you deleted everything!!!!! everyt trable is empety!!!
 nice day!
 






 <?php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        $su = Admin::user(); // Get the logged-in user

        // Check if the user is an admin or super admin
        if ($su->isRole('admin') || $su->isRole('super_admin')) {
            // Admin or Super Admin Dashboard
            return $content
                ->title('Super Admin Dashboard')
                ->row(function (Row $row) {
                    // System Health Indicator
                    $row->column(3, function (Column $column) {
                        // Example logic for system health
                        $serverLoad = sys_getloadavg()[0]; // Get server load
                        $systemHealth = $serverLoad < 1 ? 'Good' : ($serverLoad < 2 ? 'Warning' : 'Critical');
                        $color = $systemHealth === 'Good' ? 'green' : ($systemHealth === 'Warning' ? 'yellow' : 'red');
                        $box = new Box('System Health', '<div style="text-align:center; margin:0; font-size:40px; color:' . $color . '">&#9679;</div>');
                        $box->content('Status: ' . $systemHealth . ' (Server Load: ' . $serverLoad . ')');
                        $box->style('info');
                        $box->solid();
                        $column->append($box);
                    });
                    });

                    // Total Active Users
                    $row->column(3, function (Column $column) {
                        $activeUsers = User::where('is_active', true)->count(); // Query for active users
                        $box = new Box('Active Users', '<h3 style="text-align:center; margin:0; font-size:40px">' . $activeUsers . '</h3>');
                        $box->content('Users currently logged in');
                        $box->style('success');
                        $box->solid();
                        $column->append($box);
                    });

                    // Total Number of Users
                    $row->column(3, function (Column $column) {
                        $totalUsers = User::count(); // Query for total users
                        $box = new Box('Total Users', '<h3 style="text-align:center; margin:0; font-size:40px">' . $totalUsers . '</h3>');
                        $box->content('All registered users');
                        $box->style('primary');
                        $box->solid();
                        $column->append($box);
                    });

                    // Total Number of Companies
                    $row->column(3, function (Column $column) {
                        $totalCompanies = Company::count(); // Query for total companies
                        $box = new Box('Total Companies', '<h3 style="text-align:center; margin:0; font-size:40px">' . $totalCompanies . '</h3>');
                        $box->content('All registered companies');
                        $box->style('warning');
                        $box->solid();
                        $column->append($box);
                    });
              
        } else {
            // Company User Dashboard
            $company = Company::find($su->company_id);

            if (!$company) {
                return $content
                    ->title('Dashboard')
                    ->description('Company not found')
                    ->row('No company data available for this user.');
            }

            return $content
                ->title($company->name . " - Dashboard")
                ->description('Hello ' . $su->name)
                ->row(function (Row $row) use ($su) {
            
                    $row->column(3, function (Column $column) use ($su) {
                        // Dynamically calculate total sales
                        $totalSales = \App\Models\Sale::where('company_id', $su->company_id)
                            ->selectRaw('SUM(quantity * selling_price) as total_sale')
                            ->value('total_sale');
                    
                        $box = new Box('Sales', '<h3 style="text-align:center; margin:0; font-size:40px">' . ($totalSales ?? 0) . '</h3>');
                        $box->content('Total Sales: ' . ($totalSales ?? 0));
                        $box->style('success');
                        $box->solid();
                        $column->append($box);
                    });
                    $row->column(3, function (Column $column) use ($su) {
                        // Dynamically calculate total expenses
                        $totalExpenses = \App\Models\Expense::where('company_id', $su->company_id)
                            ->selectRaw('SUM(quantity * buying_price) as total_expense')
                            ->value('total_expense');
                    
                        $box = new Box('Expenses', '<h3 style="text-align:center; margin:0; font-size:40px">' . ($totalExpenses ?? 0) . '</h3>');
                        $box->content('Total Expenses: ' . ($totalExpenses ?? 0));
                        $box->style('primary');
                        $box->solid();
                        $column->append($box);
                    });

                    $row->column(3, function (Column $column) use ($su) {
                        // Dynamically calculate total purchases
                        $totalPurchases = \App\Models\Purchase::where('company_id', $su->company_id)
                            ->selectRaw('SUM(quantity * buying_price) as total_purchase')
                            ->value('total_purchase');
                    
                        $box = new Box('Purchases', '<h3 style="text-align:center; margin:0; font-size:40px">' . ($totalPurchases ?? 0) . '</h3>');
                        $box->content('Total Purchases: ' . ($totalPurchases ?? 0));
                        $box->style('info');
                        $box->solid();
                        $column->append($box);
                    });
                $row->column(3, function (Column $column) use ($su) {
                    // Dynamically calculate net profit
                    $totalSales = \App\Models\Sale::where('company_id', $su->company_id)
                        ->selectRaw('SUM(quantity * selling_price) as total_sale')
                        ->value('total_sale');

                    $totalExpenses = \App\Models\Expense::where('company_id', $su->company_id)
                        ->selectRaw('SUM(quantity * buying_price) as total_expense')
                        ->value('total_expense');

                    $totalPurchases = \App\Models\Purchase::where('company_id', $su->company_id)
                        ->selectRaw('SUM(quantity * buying_price) as total_purchase')
                        ->value('total_purchase');

                    $netProfit = ($totalSales ?? 0) - (($totalExpenses ?? 0) + ($totalPurchases ?? 0));

                    $box = new Box('Net Profit', '<h3 style="text-align:center; margin:0; font-size:40px">' . $netProfit . '</h3>');
                    $box->content('Net Profit: ' . $netProfit);
                    $box->style('warning');
                    $box->solid();
                    $column->append($box);
                });
                });
                
    }
  

}
}