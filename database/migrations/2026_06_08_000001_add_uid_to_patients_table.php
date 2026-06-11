<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            if (! Schema::hasColumn('patients', 'uid')) {
                $table->string('uid')->nullable()->unique()->after('id');
            }
        });

        $patients = DB::table('patients')->whereNull('uid')->get();

        foreach ($patients as $patient) {
            $uid = $this->generateUniqueUid();
            DB::table('patients')->where('id', $patient->id)->update(['uid' => $uid]);
        }
    }

    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            if (Schema::hasColumn('patients', 'uid')) {
                $table->dropUnique(['uid']);
                $table->dropColumn('uid');
            }
        });
    }

    protected function generateUniqueUid(): string
    {
        do {
            $uid = 'P-' . strtoupper(Str::random(8));
        } while (DB::table('patients')->where('uid', $uid)->exists());

        return $uid;
    }
};
