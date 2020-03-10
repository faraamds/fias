<?php

use Illuminate\Support\Facades\DB;

\Illuminate\Support\Facades\Artisan::call('fias:load-procedures');

echo("done\nCreating house tmp table ...");
DB::select('select * from fias_address_create_house_tmp_table()');
echo("done\nCreating room tmp table ...");
DB::select('select * from fias_address_create_room_tmp_table()');
echo("done\nCreating fias_house_room_tmp table ...");
DB::select('select * from fias_address_create_house_room_table()');
echo("done\nDeleting fias_house_tmp table ...");
DB::delete('drop table fias_house_tmp');
echo("done\nDeleting fias_room_tmp table ...");
DB::delete('drop table fias_room_tmp');
echo("done\nCreating ao_tmp table ...");
DB::select('select * from fias_address_create_ao_tmp_table()');
echo("done\nCreating address search table ...");
DB::select('select * from fias_address_fill_help_search_table_address_full()');
echo("done\nDeleting fias_ao_tmp table ...");
echo("done\nDeleting house room tmp table ...");
DB::delete('drop table fias_house_room_tmp');
echo("done\n");
