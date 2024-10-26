<?php

use Illuminate\Support\Facades\Schedule;
Schedule::command('events:remind')->dailyAt('22:30'); 