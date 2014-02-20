<?php

function getData($model, $aColumns, $cllAccion = array(), $where = "") {
    $CI = & get_instance();
    $sIndexColumn = "id";
    $controller_name = strtolower($CI->uri->segment(1));
    /*
     * Ordering
     */
    $sOrder = "";
    $x = array_keys($aColumns);
    if (isset($_GET['iSortCol_0'])) {
        $sOrder = "";
        for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
            if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
//                $sOrder .= "" . $aColumns[intval($_GET['iSortCol_' . $i])] . " " .
                $idx = intval($_GET['iSortCol_' . $i]);
                $sOrder .= "" . ($x[$idx]=='0')?$aColumns[$idx]:$x[$idx] . " " .
//                $sOrder .= "" . $x[intval($idx)]. " " .
                        ( $_GET['sSortDir_' . $i] ) . ", ";
            }
        }

        $sOrder = substr_replace($sOrder, "", -2);
    }
    /* Filtro de search */
    $sWhere = "";
    if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
        $sWhere = "(";
        for ($i = 1; $i < count($aColumns); $i++) {
            $idx = intval($i);
//            $sWhere .= $aColumns[$i] . " LIKE '%" . ( $_GET['sSearch'] ) . "%' OR ";
            $sWhere .= ($x[$idx]=='0')?$aColumns[$idx]:$x[$idx] . " LIKE '%" . ( $_GET['sSearch'] ) . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
    /* Individual column filtering */
//    for ($i = 1; $i < count($aColumns); $i++) {
    foreach ($aColumns as $idx => $col) {
        if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
            if ($sWhere == "") {
                $sWhere = " where ";
            } else {
                $sWhere .= " AND ";
            }
            $sWhere .= $aColumns[$i] . " LIKE '%" . ($_GET['sSearch_' . $i]) . "%' ";
        }
    }
    $page = isset($_GET['iDisplayStart']) ? $_GET['iDisplayStart'] : 0;
    $offset = isset($_GET['iDisplayLength']) ? $_GET['iDisplayLength'] : 0;

    if ($where != "")
        if ($sWhere == "")
            $sWhere = $where . ' ';
        else
            $sWhere .= " AND " . $where . ' ';

    $rResult = $CI->$model->get_all($offset, ($page == null ? 0 : $page), $sWhere, $sOrder);
    $iFilteredTotal = $CI->$model->get_total($where)->total;
//    $iFilteredTotal = $CI->$model->get_total()->total;
    $iTotal = $rResult->num_rows();
    /*
     * Output
     */
    $output = array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
//        "sWhere" => $sWhere,
        "aaData" => array()
    );

    $id = 0;
    $limit = count($cllAccion) == 0 ? count($aColumns) : count($aColumns) - 1;
    foreach ($rResult->result_array() as $aRow) {
        $row = array();
//        for ($i = 0; $i < count($aColumns); $i++) {
        foreach ($aColumns as $idx => $col) {
            $row[] = getCommonColumn($aRow, $idx, $col, $id);
        }

        $acciones = getColumnAccion($cllAccion, $id);
        if (count($cllAccion))
            $row[] = $acciones;

        $output['aaData'][] = $row;
    }
    return json_encode($output);
}

function getCommonColumn($row, $idx, $column, &$id) {
    if (!is_array($column))
        return $row[$column];
    $dato = "";
    if (isset($column['limit']))
        $dato = character_limiter($row[$idx], $column['limit']);
    else
        $dato = $row[$idx];

//  if (array_key_exists('es_mas', $column)) {
    if (isset($column['checked'])) {
        $id = mb_strtolower($dato);
        if (isset($column['es_mas'])) {
            return "<input type='checkbox' id='$dato' value='" . $dato . "'/>";
        } else {
            return '<img src="../images/ico/add.png">';
        }
    }
    if (isset($column['email']))
        return mailto($row[$column], $dato);
    return $dato;
}

function get_key()
{
    
}

function getColumnAccion($cllAccion, $id) {
    $CI = & get_instance();
    $controller_name = strtolower($CI->uri->segment(1));
    if (count($cllAccion) == 0)
        return;
    $accion = "";
    foreach ($cllAccion as $acc) {
        //$width = ;
//	$height = ;
        $accion.=anchor($controller_name . "/" . $acc['function'] . "?id=$id&width=" . (isset($acc['width']) ? $acc['width'] : 300) . "&height=" . (isset($acc['height']) ? $acc['height'] : 450), $CI->lang->line($acc['comun_language']), array('class' => isset($acc['class']) ? $acc['class'] : '', 'title' => $CI->lang->line($controller_name . $acc['language']))) . nbs();
    }
    return $accion;
}

?>
