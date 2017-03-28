<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
	public function listItems()
	{
		return $this->hasMany('TodoItem');
	}

	public function delete()
	{
		TodoItem::where('todo_list_id', $this->id)->delete();
		parent::delete();
	}
}
