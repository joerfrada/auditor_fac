<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dhtmlx\Connector\SchedulerConnector;

use App\Models\Programa;
use App\Models\Auditoria;
use App\Models\SchedulerEvent;
use App\Models\UsersLDAP;

class DashboardController extends Controller
{
    public function __construct() {

		$this->middleware('auth');

	}
    
	public function index() {

		// Vista
		$idPersonal = auth()->user()->IdPersonal;

		$programas = Programa::getByJefeAndSuplente($idPersonal);
		$auditorias = Auditoria::getByInspectorAndAuditor($idPersonal);
		return view('partials.dashboard')
				->with('programas', $programas)
				->with('auditorias', $auditorias)
				->with('id', $idPersonal);
	}

	public function data() {
        $connector = new SchedulerConnector(null, "PHPLaravel");
        $connector->configure(new SchedulerEvent(), "event_id", "start_date, end_date, event_name");
        $connector->render();
    }
}
