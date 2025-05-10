<?php

namespace App\Admin\Controllers;

use App\Models\Sale;
use App\Models\User; // Corrected namespace for User model
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

class SalesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Sales';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Sale());
        $u =Admin::user();
      // Check if the user is not a Super Admin
    if ($u->role !== 'super_admin') {
        // Restrict data to the user's company
        $grid->model()->where('company_id', $u->company_id);
    }


       


        $grid->disableBatchActions();
        $grid->quickSearch('product_name', 'quantity', 'selling_price', 'date', 'time', 'qr_code');
        $grid->column('company_id', __('Company Id'))->sortable()->hide();
        $grid->column('date', __('Date'))->sortable();
        $grid->column('time', __('Time'))->sortable();
        $grid->column('qr_code', __('QR Code'))->sortable(); 
        $grid->column('product_name', __('Product Name'))->sortable();
        $grid->column('quantity', __('Quantity'))->sortable();
        $grid->column('selling_price', __('Selling Price'))->sortable();
        $grid->column('total_sale', __('Total Sale'))->display(function () {
            return $this->quantity * $this->selling_price;
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
        $show = new Show(Sale::findOrFail($id));
        $show->field('company_id', __('Company Id'));
        $show->field('product_name', __('Product Name'));
        $show->field('quantity', __('Quantity'));
        $show->field('selling_price', __('Selling Price'));
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
        $form = new Form(new Sale());
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
        $form->number('quantity', __('Quantity'))->rules('required|integer');
        $form->decimal('selling_price', __('Selling Price'))->rules('required|numeric');
        $form->date('date', __('Date'))->default(date('Y-m-d'))->rules('required');
        $form->time('time', __('Time'))->default(date('H:i:s'))->rules('required');
        $form->text('qr_code', __('QR Code'))->rules('nullable'); 
    
        return $form;
    }
}