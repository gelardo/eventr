<?php

use Illuminate\Support\Facades\Schedule;
Schedule::command('events:remind')->daily();