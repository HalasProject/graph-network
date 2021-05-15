<?php

namespace App\Http\Controllers;

use App\Node;
use App\Graph;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;

class NodeController extends BaseController
{

    public function createNode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'graph_id' => 'required|exists:App\Graph,id'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->messages(),
                'message' => 'Node created successfully',
                'status' => false
            ], 422);
        } else {
            if ($node = Node::create($request->all())) {
                return response()->json([
                    'data' => $node,
                    'message' => 'Node created successfully',
                    'status' => true
                ], 201);
            }
        }
    }

    public function oneNode($id)
    {
        $node = Node::with('relations')->findOrFail($id);
        return response()->json([
            'data' => $node,
            'status' => true
        ], 200);
    }

    public function deleteNode($id)
    {
        try {
            Node::destroy($id);
            return response()->json([
                'message' => 'Node Deleted Successfully',
                'status'  => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error durring Npde destroy',
                'error' => $e,
                'status'  => true
            ], 400);
        }
    }
}
