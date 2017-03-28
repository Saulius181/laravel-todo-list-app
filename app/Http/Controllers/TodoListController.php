<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TodoList;
use App\TodoItem;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class TodoListController extends Controller
{
//	public function __construct()
//	{
//		$this->beforeFilter('csrf', array('on' => ['post', 'put', 'delete']));
//	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$todo_lists = TodoList::all(); 
		return View::make('todos.index')->with('todo_lists', $todo_lists);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return View::make('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		// define rules
		$rules = array(
				'name' => array('required', 'unique:todo_lists')
			);

		// pass input to validator
		$validator = Validator::make(Input::all(), $rules);

		// test if input fails
		if ($validator->fails()) {
			return Redirect::route('todos.create')->withErrors($validator)->withInput();
		}



		$name = Input::get('name');
		$list = new TodoList();
		$list->name = $name;
		$list->save();
		return Redirect::route('todos.index')->withMessage('List Was Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$list = TodoList::findOrFail($id);
		$items = $list->listItems()->get();
		return View::make('todos.show')
			->withList($list)
			->withItems($items);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$list = TodoList::findOrFail($id);
		return View::make('todos.edit')->withList($list);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		// define rules
		$rules = array(
				'name' => array('required', 'unique:todo_lists')
			);

		// pass input to validator
		$validator = Validator::make(Input::all(), $rules);

		// test if input fails
		if ($validator->fails()) {
			return Redirect::route('todos.edit', $id)->withErrors($validator)->withInput();
		}

		$name = Input::get('name');
		$list = TodoList::findOrFail($id);
		$list->name = $name;
		$list->update();
		return Redirect::route('todos.index')->withMessage('List Was Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

		$todo_list = TodoList::findOrFail($id)->delete();

		return Redirect::route('todos.index')->withMessage('Item Deleted!');
    }
}
