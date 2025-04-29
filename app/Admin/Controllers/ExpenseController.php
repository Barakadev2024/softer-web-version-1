<?php

namespace App\Admin\Controllers;

use App\Models\Expense;
use App\Models\Sale;
use App\Models\Purchase;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;

class ExpenseController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Expenses';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Expense());
        $u =Admin::user();
      // Check if the user is not a Super Admin
    if ($u->role !== 'super_admin') {
        // Restrict data to the user's company
        $grid->model()->where('company_id', $u->company_id);
    }


       


        $grid->disableBatchActions();
        $grid->quickSearch('product_name', 'quantity', 'selling_price', 'date', 'time', 'qr_code');
        $grid->column('company_id', __('Company Id'))->sortable();
        $grid->column('date', __('Date'))->sortable();
        $grid->column('time', __('Time'))->sortable();
        $grid->column('qr_code', __('QR Code'))->sortable(); 
        $grid->column('product_name', __('Product Name'))->sortable();
        $grid->column('organisation_name', __('Organisation Name'))->sortable();
        $grid->column('quantity', __('Quantity'))->sortable();
        $grid->column('buying_price', __('buying Price'))->sortable();
        $grid->column('total_expense', __('Total Expense'))->display(function () {
            return $this->quantity * $this->buying_price;
        })->sortable();
       
    

        return $grid;
    }

    /**'
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Expense::findOrFail($id));
        $show->field('company_id', __('Company Id'));
        $show->field('product_name', __('Product Name'));
        $show->field('organisation_name', __('Organisation Name'));
        $show->field('quantity', __('Quantity'));
        $show->field('buying_price', __('buying Price'));
        $show->field('date', __('Date'));
        $show->field('time', __('Time'));
        $show->field('qr_code', __('QR Code'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Expense());
        $u =Admin::user();

        
  // Check if the user is a Super Admin
  if ($u->role === 'super_admin') {
    // Allow Super Admins to select the company manually
    $form->select('company_id', __('Company ID'))
        ->options(\App\Models\Company::all()->pluck('name', 'id'))
        ->rules('required');
} else {
    // Automatically set the company_id for regular users
    $form->hidden('company_id', __('Company ID'))->default($u->company_id);
}
    

        $form->text('product_name', __('Product Name'))->rules('required');
        $form->text('organisation_name', __('Organisation Name'))->rules('required');
        $form->number('quantity', __('Quantity'))->rules('required|integer');
        $form->decimal('buying_price', __('buying Price'))->rules('required|numeric');
        $form->date('date', __('Date'))->default(date('Y-m-d'))->rules('required');
        $form->time('time', __('Time'))->default(date('H:i:s'))->rules('required');
        $form->text('qr_code', __('QR Code'))->rules('nullable'); 
    
        return $form;
    }
}