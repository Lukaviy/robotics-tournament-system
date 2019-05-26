<?php declare(strict_types=1);

namespace App\Admin\Controllers;

use App\Models\Problem;
use App\Http\Controllers\Controller;
use App\Models\RobotType;
use App\Models\Tournament;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\Actions;
use Encore\Admin\Grid\Tools;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ProblemController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    protected function grid() : Grid
    {
        $grid = new Grid(new Problem);
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
        $show = new Show(Problem::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    protected function form() : Form
    {
        $form = new Form(new Problem);

        $form->text('name', 'Name');
        $form->text('repository', 'Repository');
        $form->multipleSelect('tournament_id', 'Tournament')->options(Tournament::all()->pluck('name', 'id'));
        $form->select('robot_type_id', 'Robot Type')->options(RobotType::all()->pluck('name', 'id'));

        return $form;
    }
}
