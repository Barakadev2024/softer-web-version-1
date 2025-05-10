<?php

namespace App\Admin\Controllers;

use App\Models\Company; // Fixed namespace casing
use App\Models\User; // Corrected namespace for User model
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;

class CompanyController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'companies';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Company());

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('owner_id', __('Owner id'));
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
        $grid->column('logo', __('Logo'));
        $grid->column('website', __('Website'));
        $grid->column('status', __('Status'));
        $grid->column('licence_expire', __('Licence expire'));
        $grid->column('address', __('Address'));
        $grid->column('phone_number', __('Phone number'));
        $grid->column('phone_number2', __('Phone number2'));
        $grid->column('pobox', __('Pobox')); // Fixed column name

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Company::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('owner_id', __('Owner id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('logo', __('Logo'));
        $show->field('website', __('Website'));
        $show->field('status', __('Status'));
        $show->field('licence_expire', __('Licence expire'));
        $show->field('address', __('Address'));
        $show->field('phone_number', __('Phone number'));
        $show->field('phone_number2', __('Phone number2'));
        $show->field('pobox', __('Pobox'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        //get admin-role-users records
        $admin_role_users=DB::table('admin_role_users')->where([
           'role_id' => 2
        ])->get();

        $company_admins = [];
        foreach($admin_role_users as $key => $value) {
            $user = User::find($value->user_id); // Ensure the correct class is used
            if($user == null){
                continue;
            }
            $company_admins[$user->id] = $user->name.'-'.$user->id;
        }
          
        
        $form = new Form(new Company());

        $form->text('owner_id', __('owner_id'))
        ->options($company_admins)
        ->rules('required');

        $form->text('name', __('Company Name')) ->rules('required');
    //company id
        $form->text('company_id', __('Company ID'))->rules('required');
        $form->email('email', __('Email'));
        $form->image('logo', __('Logo'));
        $form->url('website', __('Website'));
        $form->text('status', __('Company Status'));
        $form->date('licence_expire', __('Licence expire'))->default(date('Y-m-d'));
        $form->text('address', __('Address'));
        $form->text('phone_number', __('Phone number'));
        $form->text('phone_number2', __('Phone number2'));
        $form->text('pobox', __('Pobox'));

        return $form;
    }
}
