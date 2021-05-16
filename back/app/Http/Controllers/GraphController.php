<?php

namespace App\Http\Controllers;

use App\Graph;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class GraphController extends BaseController
{
    public function allGraphs()
    {
        $graphs = Graph::orderBy('created_at', 'DESC')->get();
        return response()->json([
            'data' => $graphs,
            'status' => true
        ]);
    }

    public function createGraph(Request $request)
    {
        if ($graph = Graph::create($request->all())) {
            return response()->json([
                'data' => $graph,
                'message' => 'Graph created successfully',
                'status' => true
            ]);
        }
    }

    public function oneGraph($id)
    {
        $graph = Graph::findOrFail($id);
        return response()->json([
            'data' => $graph,
            'status' => true
        ], 200);
    }

    public function oneGraphStatistics($id)
    {
        $graph = Graph::with('nodes', 'nodes.relations')->findOrFail($id);
        return response()->json([
            'data' => $graph,
            'status' => true
        ], 200);
    }

    public function deleteGraph($id)
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

    public function editGraph($id, Request $request)
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
