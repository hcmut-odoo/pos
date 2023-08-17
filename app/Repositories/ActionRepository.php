<?php

namespace App\Repositories;

use App\Models\Action;

class ActionRepository
{
    public function get($id)
    {
        return Action::find($id);
    }

    public function remove($id)
    {
        return Action::where('id', $id)->delete();
    }

    public function create($controller, $method)
    {
        return Action::create([
            'controller' => $controller,
            'method' => $method
        ]);
    }

    public function getAll()
    {
        return Action::all();
    }

    public function pagination($perPage, $page)
    {
        return Action::paginate($perPage, ['*'], 'page', $page);
    }

    public function search($criteria, $selected)
    {
        return Action::query()
            ->when(isset($criteria['id']), function ($query) use ($criteria) {
                $query->where('id', $criteria['id']);
            })
            ->when(isset($criteria['resource_id']), function ($query) use ($criteria) {
                $query->where('resource_id', $criteria['resource_id']);
            })
            ->when(isset($criteria['permission_id']), function ($query) use ($criteria) {
                $query->where('permission_id', $criteria['permission_id']);
            })
            ->when(isset($criteria['controller']), function ($query) use ($criteria) {
                $query->where('controller', $criteria['controller']);
            })
            ->when(isset($criteria['method']), function ($query) use ($criteria) {
                $query->where('method', $criteria['method']);
            })
            ->get($selected ?? ['*']);
    }

    public function findByResourceId($resourceId)
    {
        return Action::where('resource_id', $resourceId)->get()->toArray();
    }
}
