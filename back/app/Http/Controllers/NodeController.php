<?php

namespace App\Http\Controllers;

use App\Node;
use App\Graph;
use App\Relation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;

class NodeController extends BaseController
{

    /**
     * createNode
     *
     * @param  Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function createNode(Request $request): JsonResponse
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

    /**
     * oneNode
     *
     * @param  Integer $id
     * @return JsonResponse
     */
    public function oneNode($id): JsonResponse
    {
        $node = Node::with('relations')->findOrFail($id);
        return response()->json([
            'data' => $node,
            'status' => true
        ], 200);
    }

    /**
     * deleteNode
     *
     * @param  Integer $id
     * @return JsonResponse
     */
    public function deleteNode($id): JsonResponse
    {
        try {
            Node::destroy($id);
            return response()->json([
                'message' => 'Node Deleted Successfully',
                'status'  => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error durring Node destroy',
                'error' => $e,
                'status'  => true
            ], 400);
        }
    }

    /**
     * editNode
     *
     * @param  Integer $id
     * @param  Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function editNode($id, Request $request): JsonResponse
    {
        $node = Node::findOrFail($id);
        $node->tooltip = $request->tooltip;
        if ($node->save()) {
            return response()->json([
                'data' => $node,
                'message' => 'Node updated successfully',
                'status' => true
            ], 201);
        } else {
            return response()->json([
                'message' => 'Error durring Node Update',
                'status' => true
            ], 500);
        }
    }

    /**
     * createRelation
     *
     * @param  Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function createRelation(Request $request): JsonResponse
    {
        // Check if both node are in the same graph
        $nodeA = Node::findOrFail($request->node_id);
        $nodeB = Node::findOrFail($request->related_node_id);

        if ($nodeA->graph_id == $nodeB->graph_id) {
            if ($edge = Relation::create($request->all())) {
                return response()->json([
                    'data' => $edge,
                    'message' => 'Edge created successfully',
                    'status' => true
                ], 201);
            };
        } else {
            return response()->json([
                'message' => 'Node are not in the same graph !',
                'status' => false
            ], 401);
        }
    }


    /**
     * deleteRelation
     *
     * @param  Integer $id
     * @return JsonResponse
     */
    public function deleteRelation($id): JsonResponse
    {
        try {
            Relation::destroy($id);
            return response()->json([
                'message' => 'Relation Deleted Successfully',
                'status'  => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error durring Edge destroy',
                'error' => $e,
                'status'  => true
            ], 400);
        }
    }
}
