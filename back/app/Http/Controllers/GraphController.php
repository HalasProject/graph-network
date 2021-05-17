<?php

namespace App\Http\Controllers;

use App\Graph;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class GraphController extends BaseController
{
    /**
     * allGraphs
     *
     * @return JsonResponse
     */
    public function allGraphs(): JsonResponse
    {
        $graphs = Graph::orderBy('created_at', 'DESC')->get();
        return response()->json([
            'data' => $graphs,
            'status' => true
        ], 200);
    }

    /**
     * createGraph
     *
     * @param  Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function createGraph(Request $request): JsonResponse
    {
        if ($graph = Graph::create($request->all())) {
            return response()->json([
                'data' => $graph,
                'message' => 'Graph created successfully',
                'status' => true
            ]);
        }
    }

    /**
     * oneGraph
     *
     * @param  Integer $id
     * @return JsonResponse
     */
    public function oneGraph($id): JsonResponse
    {
        $graph = Graph::findOrFail($id);
        return response()->json([
            'data' => $graph,
            'status' => true
        ], 200);
    }

    /**
     * oneGraphStatistics
     *
     * @param  Integer $id
     * @return JsonResponse
     */
    public function oneGraphStatistics($id): JsonResponse
    {
        $graph = Graph::with('nodes', 'nodes.relations')->findOrFail($id);
        return response()->json([
            'data' => $graph,
            'status' => true
        ], 200);
    }

    /**
     * deleteGraph
     *
     * @param  Intefer $id
     * @return JsonResponse
     */
    public function deleteGraph($id): JsonResponse
    {
        try {
            Graph::destroy($id);
            return response()->json([
                'message' => 'Graph Deleted Successfully',
                'status'  => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error durring Graph destroy',
                'error' => $e,
                'status'  => true
            ], 400);
        }
    }

    /**
     * editGraph
     *
     * @param  Integer $id
     * @param  Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function editGraph($id, Request $request): JsonResponse
    {
        $graph = Graph::findOrFail($id);
        if ($graph->update($request->all())) {
            return response()->json([
                'data' => $graph,
                'message' => 'Graph updated successfully',
                'status' => true
            ]);
        }
    }
}
