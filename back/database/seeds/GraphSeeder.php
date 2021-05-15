<?php


use App\Node;
use App\Graph;
use App\Relation;
use Faker as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class GraphSeeder extends Seeder
{
    protected $faker;
    public function getFaker()
    {
        if (empty($this->faker)) {
            $faker = Faker\Factory::create();
            $faker->addProvider(new Faker\Provider\Base($faker));
            $faker->addProvider(new Faker\Provider\Lorem($faker));
        }
        return $this->faker = $faker;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->getFaker();
        $i = 0;
        $j = 0;
        while ($i < env('MAX_GRAPH', 10)) {
            $graph_id = Graph::create([
                'name' => $this->faker->name,
                'description' => $this->faker->text(100)
            ])->id;
            for ($j = 0; $j < env('MAX_NODES', 100); $j++) {
                Node::create([
                    'graph_id' => $graph_id,
                    'tooltip' => Str::random()
                ]);
            }
            $i++;
        }
        $i = 0;
        while ($i < 200) {
            $nodes = Node::where('graph_id', Graph::all()->random(1)->first()->id)->inRandomOrder()->limit(2)->get();
            Relation::create([
                'node_id' => $nodes[0]->id ,
                'related_node_id' => $nodes[1]->id,
            ]);
            $i++;
        }
    }
}
