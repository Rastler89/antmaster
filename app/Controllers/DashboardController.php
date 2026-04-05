<?php
require_once '../app/Models/Colony.php';
require_once '../app/Models/Stock.php';

class DashboardController extends Controller {
    public function index() {
        if (!is_logged_in()) {
            $this->view('home', ['title' => 'Bienvenido a AntMaster Pro - Gestión de Hormigas']);
            return;
        }
        
        $userId = $_SESSION['user_id'];
        $range = $_GET['range'] ?? 30; // '30', '90', '180', 'all'
        
        $colonies = Colony::getUserColonies($userId);
        $totalAnts = 0;
        foreach($colonies as $c) {
            $totalAnts += $c['poblacion_actual'];
        }

        $allStocks = Stock::where('usuario_id', '=', $userId);
        $lowStock = array_filter($allStocks, function($s) {
            return $s['cantidad'] < 10;
        });

        $data = [
            'colonies'    => $colonies,
            'totalAnts'   => $totalAnts,
            'totalSpecies'=> count(Colony::getSpeciesDistribution($userId)),
            'stocks'      => $allStocks,
            'lowStock'    => $lowStock,
            'distribution' => Colony::getSpeciesDistribution($userId),
            'globalHistory' => Colony::getGlobalHistory($userId, $range),
            'range'       => $range,
            'userName'    => $_SESSION['user_name'],
            'title'       => 'Dashboard Analítico | AntMaster Pro'
        ];
        
        $this->view('dashboard/index', $data);
    }
}
