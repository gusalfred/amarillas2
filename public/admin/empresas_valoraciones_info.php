<?php

// Global variable for table object
$empresas_valoraciones = NULL;

//
// Table class for empresas_valoraciones
//
class cempresas_valoraciones extends cTable {
	var $id_empresa_valoracion;
	var $id_empresa;
	var $id_usuario;
	var $comentario;
	var $valor;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'empresas_valoraciones';
		$this->TableName = 'empresas_valoraciones';
		$this->TableType = 'TABLE';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id_empresa_valoracion
		$this->id_empresa_valoracion = new cField('empresas_valoraciones', 'empresas_valoraciones', 'x_id_empresa_valoracion', 'id_empresa_valoracion', '`id_empresa_valoracion`', '`id_empresa_valoracion`', 19, -1, FALSE, '`id_empresa_valoracion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->id_empresa_valoracion->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_empresa_valoracion'] = &$this->id_empresa_valoracion;

		// id_empresa
		$this->id_empresa = new cField('empresas_valoraciones', 'empresas_valoraciones', 'x_id_empresa', 'id_empresa', '`id_empresa`', '`id_empresa`', 19, -1, FALSE, '`id_empresa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->id_empresa->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_empresa'] = &$this->id_empresa;

		// id_usuario
		$this->id_usuario = new cField('empresas_valoraciones', 'empresas_valoraciones', 'x_id_usuario', 'id_usuario', '`id_usuario`', '`id_usuario`', 19, -1, FALSE, '`id_usuario`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->id_usuario->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_usuario'] = &$this->id_usuario;

		// comentario
		$this->comentario = new cField('empresas_valoraciones', 'empresas_valoraciones', 'x_comentario', 'comentario', '`comentario`', '`comentario`', 200, -1, FALSE, '`comentario`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['comentario'] = &$this->comentario;

		// valor
		$this->valor = new cField('empresas_valoraciones', 'empresas_valoraciones', 'x_valor', 'valor', '`valor`', '`valor`', 16, -1, FALSE, '`valor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->valor->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['valor'] = &$this->valor;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`empresas_valoraciones`";
	}

	function SqlFrom() { // For backward compatibility
    	return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
    	$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
    	return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
    	$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
    	return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
    	$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
    	return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
    	$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
    	return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
    	$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
    	return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
    	$this->_SqlOrderBy = $v;
	}

	// Check if Anonymous User is allowed
	function AllowAnonymousUser() {
		switch (@$this->PageID) {
			case "add":
			case "register":
			case "addopt":
				return FALSE;
			case "edit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return FALSE;
			case "delete":
				return FALSE;
			case "view":
				return FALSE;
			case "search":
				return FALSE;
			default:
				return FALSE;
		}
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		global $conn;
		$cnt = -1;
		if ($this->TableType == 'TABLE' || $this->TableType == 'VIEW') {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		global $conn;
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Update Table
	var $UpdateTable = "`empresas_valoraciones`";

	// INSERT statement
	function InsertSQL(&$rs) {
		global $conn;
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		global $conn;
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "") {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL) {
		global $conn;
		return $conn->Execute($this->UpdateSQL($rs, $where));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "") {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if ($rs) {
			if (array_key_exists('id_empresa_valoracion', $rs))
				ew_AddFilter($where, ew_QuotedName('id_empresa_valoracion') . '=' . ew_QuotedValue($rs['id_empresa_valoracion'], $this->id_empresa_valoracion->FldDataType));
		}
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "") {
		global $conn;
		return $conn->Execute($this->DeleteSQL($rs, $where));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id_empresa_valoracion` = @id_empresa_valoracion@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id_empresa_valoracion->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id_empresa_valoracion@", ew_AdjustSql($this->id_empresa_valoracion->CurrentValue), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "empresas_valoraciones_list.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "empresas_valoraciones_list.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("empresas_valoraciones_view.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("empresas_valoraciones_view.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			return "empresas_valoraciones_add.php?" . $this->UrlParm($parm);
		else
			return "empresas_valoraciones_add.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("empresas_valoraciones_edit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("empresas_valoraciones_add.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("empresas_valoraciones_delete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id_empresa_valoracion->CurrentValue)) {
			$sUrl .= "id_empresa_valoracion=" . urlencode($this->id_empresa_valoracion->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET)) {
			$arKeys[] = @$_GET["id_empresa_valoracion"]; // id_empresa_valoracion

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_numeric($key))
				continue;
			$ar[] = $key;
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->id_empresa_valoracion->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {
		global $conn;

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->id_empresa_valoracion->setDbValue($rs->fields('id_empresa_valoracion'));
		$this->id_empresa->setDbValue($rs->fields('id_empresa'));
		$this->id_usuario->setDbValue($rs->fields('id_usuario'));
		$this->comentario->setDbValue($rs->fields('comentario'));
		$this->valor->setDbValue($rs->fields('valor'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id_empresa_valoracion
		// id_empresa
		// id_usuario
		// comentario
		// valor
		// id_empresa_valoracion

		$this->id_empresa_valoracion->ViewValue = $this->id_empresa_valoracion->CurrentValue;
		$this->id_empresa_valoracion->ViewCustomAttributes = "";

		// id_empresa
		$this->id_empresa->ViewValue = $this->id_empresa->CurrentValue;
		if (strval($this->id_empresa->CurrentValue) <> "") {
			$sFilterWrk = "`id_empresa`" . ew_SearchString("=", $this->id_empresa->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `id_empresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresas`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->id_empresa, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->id_empresa->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->id_empresa->ViewValue = $this->id_empresa->CurrentValue;
			}
		} else {
			$this->id_empresa->ViewValue = NULL;
		}
		$this->id_empresa->ViewCustomAttributes = "";

		// id_usuario
		$this->id_usuario->ViewValue = $this->id_usuario->CurrentValue;
		if (strval($this->id_usuario->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_usuario->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `id`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `users`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->id_usuario, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->id_usuario->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->id_usuario->ViewValue = $this->id_usuario->CurrentValue;
			}
		} else {
			$this->id_usuario->ViewValue = NULL;
		}
		$this->id_usuario->ViewCustomAttributes = "";

		// comentario
		$this->comentario->ViewValue = $this->comentario->CurrentValue;
		$this->comentario->ViewCustomAttributes = "";

		// valor
		if (strval($this->valor->CurrentValue) <> "") {
			switch ($this->valor->CurrentValue) {
				case $this->valor->FldTagValue(1):
					$this->valor->ViewValue = $this->valor->FldTagCaption(1) <> "" ? $this->valor->FldTagCaption(1) : $this->valor->CurrentValue;
					break;
				case $this->valor->FldTagValue(2):
					$this->valor->ViewValue = $this->valor->FldTagCaption(2) <> "" ? $this->valor->FldTagCaption(2) : $this->valor->CurrentValue;
					break;
				case $this->valor->FldTagValue(3):
					$this->valor->ViewValue = $this->valor->FldTagCaption(3) <> "" ? $this->valor->FldTagCaption(3) : $this->valor->CurrentValue;
					break;
				case $this->valor->FldTagValue(4):
					$this->valor->ViewValue = $this->valor->FldTagCaption(4) <> "" ? $this->valor->FldTagCaption(4) : $this->valor->CurrentValue;
					break;
				case $this->valor->FldTagValue(5):
					$this->valor->ViewValue = $this->valor->FldTagCaption(5) <> "" ? $this->valor->FldTagCaption(5) : $this->valor->CurrentValue;
					break;
				default:
					$this->valor->ViewValue = $this->valor->CurrentValue;
			}
		} else {
			$this->valor->ViewValue = NULL;
		}
		$this->valor->ViewCustomAttributes = "";

		// id_empresa_valoracion
		$this->id_empresa_valoracion->LinkCustomAttributes = "";
		$this->id_empresa_valoracion->HrefValue = "";
		$this->id_empresa_valoracion->TooltipValue = "";

		// id_empresa
		$this->id_empresa->LinkCustomAttributes = "";
		$this->id_empresa->HrefValue = "";
		$this->id_empresa->TooltipValue = "";

		// id_usuario
		$this->id_usuario->LinkCustomAttributes = "";
		$this->id_usuario->HrefValue = "";
		$this->id_usuario->TooltipValue = "";

		// comentario
		$this->comentario->LinkCustomAttributes = "";
		$this->comentario->HrefValue = "";
		$this->comentario->TooltipValue = "";

		// valor
		$this->valor->LinkCustomAttributes = "";
		$this->valor->HrefValue = "";
		$this->valor->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id_empresa_valoracion
		$this->id_empresa_valoracion->EditAttrs["class"] = "form-control";
		$this->id_empresa_valoracion->EditCustomAttributes = "";
		$this->id_empresa_valoracion->EditValue = $this->id_empresa_valoracion->CurrentValue;
		$this->id_empresa_valoracion->ViewCustomAttributes = "";

		// id_empresa
		$this->id_empresa->EditAttrs["class"] = "form-control";
		$this->id_empresa->EditCustomAttributes = 'disabled';
		$this->id_empresa->EditValue = ew_HtmlEncode($this->id_empresa->CurrentValue);

		// id_usuario
		$this->id_usuario->EditAttrs["class"] = "form-control";
		$this->id_usuario->EditCustomAttributes = "";
		$this->id_usuario->EditValue = ew_HtmlEncode($this->id_usuario->CurrentValue);

		// comentario
		$this->comentario->EditAttrs["class"] = "form-control";
		$this->comentario->EditCustomAttributes = "";
		$this->comentario->EditValue = ew_HtmlEncode($this->comentario->CurrentValue);

		// valor
		$this->valor->EditAttrs["class"] = "form-control";
		$this->valor->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array($this->valor->FldTagValue(1), $this->valor->FldTagCaption(1) <> "" ? $this->valor->FldTagCaption(1) : $this->valor->FldTagValue(1));
		$arwrk[] = array($this->valor->FldTagValue(2), $this->valor->FldTagCaption(2) <> "" ? $this->valor->FldTagCaption(2) : $this->valor->FldTagValue(2));
		$arwrk[] = array($this->valor->FldTagValue(3), $this->valor->FldTagCaption(3) <> "" ? $this->valor->FldTagCaption(3) : $this->valor->FldTagValue(3));
		$arwrk[] = array($this->valor->FldTagValue(4), $this->valor->FldTagCaption(4) <> "" ? $this->valor->FldTagCaption(4) : $this->valor->FldTagValue(4));
		$arwrk[] = array($this->valor->FldTagValue(5), $this->valor->FldTagCaption(5) <> "" ? $this->valor->FldTagCaption(5) : $this->valor->FldTagValue(5));
		array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
		$this->valor->EditValue = $arwrk;

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->id_empresa->Exportable) $Doc->ExportCaption($this->id_empresa);
					if ($this->id_usuario->Exportable) $Doc->ExportCaption($this->id_usuario);
					if ($this->comentario->Exportable) $Doc->ExportCaption($this->comentario);
					if ($this->valor->Exportable) $Doc->ExportCaption($this->valor);
				} else {
					if ($this->id_empresa_valoracion->Exportable) $Doc->ExportCaption($this->id_empresa_valoracion);
					if ($this->id_empresa->Exportable) $Doc->ExportCaption($this->id_empresa);
					if ($this->id_usuario->Exportable) $Doc->ExportCaption($this->id_usuario);
					if ($this->comentario->Exportable) $Doc->ExportCaption($this->comentario);
					if ($this->valor->Exportable) $Doc->ExportCaption($this->valor);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->id_empresa->Exportable) $Doc->ExportField($this->id_empresa);
						if ($this->id_usuario->Exportable) $Doc->ExportField($this->id_usuario);
						if ($this->comentario->Exportable) $Doc->ExportField($this->comentario);
						if ($this->valor->Exportable) $Doc->ExportField($this->valor);
					} else {
						if ($this->id_empresa_valoracion->Exportable) $Doc->ExportField($this->id_empresa_valoracion);
						if ($this->id_empresa->Exportable) $Doc->ExportField($this->id_empresa);
						if ($this->id_usuario->Exportable) $Doc->ExportField($this->id_usuario);
						if ($this->comentario->Exportable) $Doc->ExportField($this->comentario);
						if ($this->valor->Exportable) $Doc->ExportField($this->valor);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
		empresa_valora($rsnew['id_empresa']);
		header('Location: empresas_view.php?tab=7&id_empresa='.$rsnew['id_empresa']);
		exit;
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
		empresa_valora($rsold['id_empresa']);
		header("Location: empresas_view.php?tab=7&id_empresa=".$rsold['id_empresa'] );
		die();
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
		empresa_valora($rs['id_empresa']);
		header("Location: empresas_view.php?tab=7&id_empresa=".$rs['id_empresa'] );
		die();
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>