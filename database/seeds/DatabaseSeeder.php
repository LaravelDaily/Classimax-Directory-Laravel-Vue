<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call(PermissionSeed::class);
        $this->call(RoleSeed::class);
        $this->call(UserSeed::class);
        $this->call(RoleSeedPivot::class);
        $this->call(UserSeedPivot::class);
        $this->call(CategorySeed::class);
        $this->call(CitySeed::class);
        $this->call(CompanySeed::class);

    }
}
