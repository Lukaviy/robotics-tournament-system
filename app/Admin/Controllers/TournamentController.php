<?php declare(strict_types=1);

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Problem;
use App\Models\Tournament;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\Actions;
use Encore\Admin\Grid\Tools;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class TournamentController extends Controller
{
    use HasResourceActions;

    public function index(Content $content) : Content
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    public function show($id, Content $content) : Content
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    public function edit($id, Content $content) : Content
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    public function create(Content $content) : Content
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    protected function grid() : Grid
    {
        $grid = new Grid(new Tournament);
        $grid->disableExport();
        $grid->disableRowSelector();
        $grid->tools(function (Tools $tools) : void
        {
            $tools->disableRefreshButton(true);
            $tools->disableBatchActions(true);
            $tools->disableFilterButton(true);
        });
        $grid->actions(function (Actions $actions) : void
        {
            $actions->disableDelete();
        });
        $grid->disableColumnSelector();

        $grid->id('Id');
        $grid->name('Name');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

        return $grid;
    }

    protected function detail($id) : Show
    {
        $show = new Show(Tournament::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    protected function form() : Form
    {
        $form = new Form(new Tournament);

        $form->text('name', 'Name');
        $form->multipleSelect('problems', 'Name')->options(Problem::all()->pluck('name', "id"));

        return $form;
    }
}
