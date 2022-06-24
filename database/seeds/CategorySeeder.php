<?php


use Illuminate\Database\Seeder;

use App\Models\Category;

use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $cats = ['History', 'Maths', 'Geography', 'Physics', 'Philosophy', 'Licterature'];

        foreach ($cats as $cat) {

            $new_cat = new Category();

            $new_cat->name = $cat;
            $new_cat->slug = Str::slug($new_cat->name, '-');

            $new_cat->save();
            

        }
    }
}
