<?php include_once "empleados_info.php" ?>
<?php

// Create page object
if (!isset($avisos_categorias_grid)) $avisos_categorias_grid = new cavisos_categorias_grid();

// Page init
$avisos_categorias_grid->Page_Init();

// Page main
$avisos_categorias_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$avisos_categorias_grid->Page_Render();
?>
<?php if ($avisos_categorias->Export == "") { ?>
<script type="text/javascript">

// Page object
var avisos_categorias_grid = new ew_Page("avisos_categorias_grid");
avisos_categorias_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = avisos_categorias_grid.PageID; // For backward compatibility

// Form object
var favisos_categoriasgrid = new ew_Form("favisos_categoriasgrid");
favisos_categoriasgrid.FormKeyCountName = '<?php echo $avisos_categorias_grid->FormKeyCountName ?>';

// Validate form
favisos_categoriasgrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	this.PostAutoSuggest();
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
favisos_categoriasgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "id_categoria_nivel1", false)) return false;
	if (ew_ValueChanged(fobj, infix, "id_categoria_nivel2", false)) return false;
	return true;
}

// Form_CustomValidate event
favisos_categoriasgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
favisos_categoriasgrid.ValidateRequired = true;
<?php } else { ?>
favisos_categoriasgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
favisos_categoriasgrid.Lists["x_id_categoria_nivel1"] = {"LinkField":"x_id_categoria_nivel1","Ajax":null,"AutoFill":false,"DisplayFields":["x_categoria","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
favisos_categoriasgrid.Lists["x_id_categoria_nivel2"] = {"LinkField":"x_id_categoria_nivel2","Ajax":null,"AutoFill":false,"DisplayFields":["x_categoria","","",""],"ParentFields":["x_id_categoria_nivel1"],"FilterFields":["x_id_categoria_nivel1"],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($avisos_categorias->CurrentAction == "gridadd") {
	if ($avisos_categorias->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$avisos_categorias_grid->TotalRecs = $avisos_categorias->SelectRecordCount();
			$avisos_categorias_grid->Recordset = $avisos_categorias_grid->LoadRecordset($avisos_categorias_grid->StartRec-1, $avisos_categorias_grid->DisplayRecs);
		} else {
			if ($avisos_categorias_grid->Recordset = $avisos_categorias_grid->LoadRecordset())
				$avisos_categorias_grid->TotalRecs = $avisos_categorias_grid->Recordset->RecordCount();
		}
		$avisos_categorias_grid->StartRec = 1;
		$avisos_categorias_grid->DisplayRecs = $avisos_categorias_grid->TotalRecs;
	} else {
		$avisos_categorias->CurrentFilter = "0=1";
		$avisos_categorias_grid->StartRec = 1;
		$avisos_categorias_grid->DisplayRecs = $avisos_categorias->GridAddRowCount;
	}
	$avisos_categorias_grid->TotalRecs = $avisos_categorias_grid->DisplayRecs;
	$avisos_categorias_grid->StopRec = $avisos_categorias_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		if ($avisos_categorias_grid->TotalRecs <= 0)
			$avisos_categorias_grid->TotalRecs = $avisos_categorias->SelectRecordCount();
	} else {
		if (!$avisos_categorias_grid->Recordset && ($avisos_categorias_grid->Recordset = $avisos_categorias_grid->LoadRecordset()))
			$avisos_categorias_grid->TotalRecs = $avisos_categorias_grid->Recordset->RecordCount();
	}
	$avisos_categorias_grid->StartRec = 1;
	$avisos_categorias_grid->DisplayRecs = $avisos_categorias_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$avisos_categorias_grid->Recordset = $avisos_categorias_grid->LoadRecordset($avisos_categorias_grid->StartRec-1, $avisos_categorias_grid->DisplayRecs);

	// Set no record found message
	if ($avisos_categorias->CurrentAction == "" && $avisos_categorias_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$avisos_categorias_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($avisos_categorias_grid->SearchWhere == "0=101")
			$avisos_categorias_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$avisos_categorias_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$avisos_categorias_grid->RenderOtherOptions();
?>
<?php $avisos_categorias_grid->ShowPageHeader(); ?>
<?php
$avisos_categorias_grid->ShowMessage();
?>
<?php if ($avisos_categorias_grid->TotalRecs > 0 || $avisos_categorias->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="favisos_categoriasgrid" class="ewForm form-inline">
<?php if ($avisos_categorias_grid->ShowOtherOptions) { ?>
<div class="ewGridUpperPanel">
<?php
	foreach ($avisos_categorias_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_avisos_categorias" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_avisos_categoriasgrid" class="table ewTable">
<?php echo $avisos_categorias->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$avisos_categorias->RowType = EW_ROWTYPE_HEADER;

// Render list options
$avisos_categorias_grid->RenderListOptions();

// Render list options (header, left)
$avisos_categorias_grid->ListOptions->Render("header", "left");
?>
<?php if ($avisos_categorias->id_categoria_nivel1->Visible) { // id_categoria_nivel1 ?>
	<?php if ($avisos_categorias->SortUrl($avisos_categorias->id_categoria_nivel1) == "") { ?>
		<th data-name="id_categoria_nivel1"><div id="elh_avisos_categorias_id_categoria_nivel1" class="avisos_categorias_id_categoria_nivel1"><div class="ewTableHeaderCaption"><?php echo $avisos_categorias->id_categoria_nivel1->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id_categoria_nivel1"><div><div id="elh_avisos_categorias_id_categoria_nivel1" class="avisos_categorias_id_categoria_nivel1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $avisos_categorias->id_categoria_nivel1->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($avisos_categorias->id_categoria_nivel1->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($avisos_categorias->id_categoria_nivel1->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($avisos_categorias->id_categoria_nivel2->Visible) { // id_categoria_nivel2 ?>
	<?php if ($avisos_categorias->SortUrl($avisos_categorias->id_categoria_nivel2) == "") { ?>
		<th data-name="id_categoria_nivel2"><div id="elh_avisos_categorias_id_categoria_nivel2" class="avisos_categorias_id_categoria_nivel2"><div class="ewTableHeaderCaption"><?php echo $avisos_categorias->id_categoria_nivel2->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id_categoria_nivel2"><div><div id="elh_avisos_categorias_id_categoria_nivel2" class="avisos_categorias_id_categoria_nivel2">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $avisos_categorias->id_categoria_nivel2->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($avisos_categorias->id_categoria_nivel2->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($avisos_categorias->id_categoria_nivel2->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$avisos_categorias_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$avisos_categorias_grid->StartRec = 1;
$avisos_categorias_grid->StopRec = $avisos_categorias_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($avisos_categorias_grid->FormKeyCountName) && ($avisos_categorias->CurrentAction == "gridadd" || $avisos_categorias->CurrentAction == "gridedit" || $avisos_categorias->CurrentAction == "F")) {
		$avisos_categorias_grid->KeyCount = $objForm->GetValue($avisos_categorias_grid->FormKeyCountName);
		$avisos_categorias_grid->StopRec = $avisos_categorias_grid->StartRec + $avisos_categorias_grid->KeyCount - 1;
	}
}
$avisos_categorias_grid->RecCnt = $avisos_categorias_grid->StartRec - 1;
if ($avisos_categorias_grid->Recordset && !$avisos_categorias_grid->Recordset->EOF) {
	$avisos_categorias_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $avisos_categorias_grid->StartRec > 1)
		$avisos_categorias_grid->Recordset->Move($avisos_categorias_grid->StartRec - 1);
} elseif (!$avisos_categorias->AllowAddDeleteRow && $avisos_categorias_grid->StopRec == 0) {
	$avisos_categorias_grid->StopRec = $avisos_categorias->GridAddRowCount;
}

// Initialize aggregate
$avisos_categorias->RowType = EW_ROWTYPE_AGGREGATEINIT;
$avisos_categorias->ResetAttrs();
$avisos_categorias_grid->RenderRow();
if ($avisos_categorias->CurrentAction == "gridadd")
	$avisos_categorias_grid->RowIndex = 0;
if ($avisos_categorias->CurrentAction == "gridedit")
	$avisos_categorias_grid->RowIndex = 0;
while ($avisos_categorias_grid->RecCnt < $avisos_categorias_grid->StopRec) {
	$avisos_categorias_grid->RecCnt++;
	if (intval($avisos_categorias_grid->RecCnt) >= intval($avisos_categorias_grid->StartRec)) {
		$avisos_categorias_grid->RowCnt++;
		if ($avisos_categorias->CurrentAction == "gridadd" || $avisos_categorias->CurrentAction == "gridedit" || $avisos_categorias->CurrentAction == "F") {
			$avisos_categorias_grid->RowIndex++;
			$objForm->Index = $avisos_categorias_grid->RowIndex;
			if ($objForm->HasValue($avisos_categorias_grid->FormActionName))
				$avisos_categorias_grid->RowAction = strval($objForm->GetValue($avisos_categorias_grid->FormActionName));
			elseif ($avisos_categorias->CurrentAction == "gridadd")
				$avisos_categorias_grid->RowAction = "insert";
			else
				$avisos_categorias_grid->RowAction = "";
		}

		// Set up key count
		$avisos_categorias_grid->KeyCount = $avisos_categorias_grid->RowIndex;

		// Init row class and style
		$avisos_categorias->ResetAttrs();
		$avisos_categorias->CssClass = "";
		if ($avisos_categorias->CurrentAction == "gridadd") {
			if ($avisos_categorias->CurrentMode == "copy") {
				$avisos_categorias_grid->LoadRowValues($avisos_categorias_grid->Recordset); // Load row values
				$avisos_categorias_grid->SetRecordKey($avisos_categorias_grid->RowOldKey, $avisos_categorias_grid->Recordset); // Set old record key
			} else {
				$avisos_categorias_grid->LoadDefaultValues(); // Load default values
				$avisos_categorias_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$avisos_categorias_grid->LoadRowValues($avisos_categorias_grid->Recordset); // Load row values
		}
		$avisos_categorias->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($avisos_categorias->CurrentAction == "gridadd") // Grid add
			$avisos_categorias->RowType = EW_ROWTYPE_ADD; // Render add
		if ($avisos_categorias->CurrentAction == "gridadd" && $avisos_categorias->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$avisos_categorias_grid->RestoreCurrentRowFormValues($avisos_categorias_grid->RowIndex); // Restore form values
		if ($avisos_categorias->CurrentAction == "gridedit") { // Grid edit
			if ($avisos_categorias->EventCancelled) {
				$avisos_categorias_grid->RestoreCurrentRowFormValues($avisos_categorias_grid->RowIndex); // Restore form values
			}
			if ($avisos_categorias_grid->RowAction == "insert")
				$avisos_categorias->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$avisos_categorias->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($avisos_categorias->CurrentAction == "gridedit" && ($avisos_categorias->RowType == EW_ROWTYPE_EDIT || $avisos_categorias->RowType == EW_ROWTYPE_ADD) && $avisos_categorias->EventCancelled) // Update failed
			$avisos_categorias_grid->RestoreCurrentRowFormValues($avisos_categorias_grid->RowIndex); // Restore form values
		if ($avisos_categorias->RowType == EW_ROWTYPE_EDIT) // Edit row
			$avisos_categorias_grid->EditRowCnt++;
		if ($avisos_categorias->CurrentAction == "F") // Confirm row
			$avisos_categorias_grid->RestoreCurrentRowFormValues($avisos_categorias_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$avisos_categorias->RowAttrs = array_merge($avisos_categorias->RowAttrs, array('data-rowindex'=>$avisos_categorias_grid->RowCnt, 'id'=>'r' . $avisos_categorias_grid->RowCnt . '_avisos_categorias', 'data-rowtype'=>$avisos_categorias->RowType));

		// Render row
		$avisos_categorias_grid->RenderRow();

		// Render list options
		$avisos_categorias_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($avisos_categorias_grid->RowAction <> "delete" && $avisos_categorias_grid->RowAction <> "insertdelete" && !($avisos_categorias_grid->RowAction == "insert" && $avisos_categorias->CurrentAction == "F" && $avisos_categorias_grid->EmptyRow())) {
?>
	<tr<?php echo $avisos_categorias->RowAttributes() ?>>
<?php

// Render list options (body, left)
$avisos_categorias_grid->ListOptions->Render("body", "left", $avisos_categorias_grid->RowCnt);
?>
	<?php if ($avisos_categorias->id_categoria_nivel1->Visible) { // id_categoria_nivel1 ?>
		<td data-name="id_categoria_nivel1"<?php echo $avisos_categorias->id_categoria_nivel1->CellAttributes() ?>>
<?php if ($avisos_categorias->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $avisos_categorias_grid->RowCnt ?>_avisos_categorias_id_categoria_nivel1" class="form-group avisos_categorias_id_categoria_nivel1">
<?php $avisos_categorias->id_categoria_nivel1->EditAttrs["onchange"] = "ew_UpdateOpt.call(this, ['x" . $avisos_categorias_grid->RowIndex . "_id_categoria_nivel2']); " . @$avisos_categorias->id_categoria_nivel1->EditAttrs["onchange"]; ?>
<select data-field="x_id_categoria_nivel1" id="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel1" name="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel1"<?php echo $avisos_categorias->id_categoria_nivel1->EditAttributes() ?>>
<?php
if (is_array($avisos_categorias->id_categoria_nivel1->EditValue)) {
	$arwrk = $avisos_categorias->id_categoria_nivel1->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($avisos_categorias->id_categoria_nivel1->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $avisos_categorias->id_categoria_nivel1->OldValue = "";
?>
</select>
<script type="text/javascript">
favisos_categoriasgrid.Lists["x_id_categoria_nivel1"].Options = <?php echo (is_array($avisos_categorias->id_categoria_nivel1->EditValue)) ? ew_ArrayToJson($avisos_categorias->id_categoria_nivel1->EditValue, 1) : "[]" ?>;
</script>
</span>
<input type="hidden" data-field="x_id_categoria_nivel1" name="o<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel1" id="o<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel1" value="<?php echo ew_HtmlEncode($avisos_categorias->id_categoria_nivel1->OldValue) ?>">
<?php } ?>
<?php if ($avisos_categorias->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $avisos_categorias_grid->RowCnt ?>_avisos_categorias_id_categoria_nivel1" class="form-group avisos_categorias_id_categoria_nivel1">
<?php $avisos_categorias->id_categoria_nivel1->EditAttrs["onchange"] = "ew_UpdateOpt.call(this, ['x" . $avisos_categorias_grid->RowIndex . "_id_categoria_nivel2']); " . @$avisos_categorias->id_categoria_nivel1->EditAttrs["onchange"]; ?>
<select data-field="x_id_categoria_nivel1" id="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel1" name="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel1"<?php echo $avisos_categorias->id_categoria_nivel1->EditAttributes() ?>>
<?php
if (is_array($avisos_categorias->id_categoria_nivel1->EditValue)) {
	$arwrk = $avisos_categorias->id_categoria_nivel1->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($avisos_categorias->id_categoria_nivel1->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $avisos_categorias->id_categoria_nivel1->OldValue = "";
?>
</select>
<script type="text/javascript">
favisos_categoriasgrid.Lists["x_id_categoria_nivel1"].Options = <?php echo (is_array($avisos_categorias->id_categoria_nivel1->EditValue)) ? ew_ArrayToJson($avisos_categorias->id_categoria_nivel1->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php } ?>
<?php if ($avisos_categorias->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $avisos_categorias->id_categoria_nivel1->ViewAttributes() ?>>
<?php echo $avisos_categorias->id_categoria_nivel1->ListViewValue() ?></span>
<input type="hidden" data-field="x_id_categoria_nivel1" name="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel1" id="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel1" value="<?php echo ew_HtmlEncode($avisos_categorias->id_categoria_nivel1->FormValue) ?>">
<input type="hidden" data-field="x_id_categoria_nivel1" name="o<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel1" id="o<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel1" value="<?php echo ew_HtmlEncode($avisos_categorias->id_categoria_nivel1->OldValue) ?>">
<?php } ?>
<a id="<?php echo $avisos_categorias_grid->PageObjName . "_row_" . $avisos_categorias_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($avisos_categorias->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_id_aviso_categoria" name="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_aviso_categoria" id="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_aviso_categoria" value="<?php echo ew_HtmlEncode($avisos_categorias->id_aviso_categoria->CurrentValue) ?>">
<input type="hidden" data-field="x_id_aviso_categoria" name="o<?php echo $avisos_categorias_grid->RowIndex ?>_id_aviso_categoria" id="o<?php echo $avisos_categorias_grid->RowIndex ?>_id_aviso_categoria" value="<?php echo ew_HtmlEncode($avisos_categorias->id_aviso_categoria->OldValue) ?>">
<?php } ?>
<?php if ($avisos_categorias->RowType == EW_ROWTYPE_EDIT || $avisos_categorias->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_id_aviso_categoria" name="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_aviso_categoria" id="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_aviso_categoria" value="<?php echo ew_HtmlEncode($avisos_categorias->id_aviso_categoria->CurrentValue) ?>">
<?php } ?>
	<?php if ($avisos_categorias->id_categoria_nivel2->Visible) { // id_categoria_nivel2 ?>
		<td data-name="id_categoria_nivel2"<?php echo $avisos_categorias->id_categoria_nivel2->CellAttributes() ?>>
<?php if ($avisos_categorias->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $avisos_categorias_grid->RowCnt ?>_avisos_categorias_id_categoria_nivel2" class="form-group avisos_categorias_id_categoria_nivel2">
<select data-field="x_id_categoria_nivel2" id="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel2" name="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel2"<?php echo $avisos_categorias->id_categoria_nivel2->EditAttributes() ?>>
<?php
if (is_array($avisos_categorias->id_categoria_nivel2->EditValue)) {
	$arwrk = $avisos_categorias->id_categoria_nivel2->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($avisos_categorias->id_categoria_nivel2->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $avisos_categorias->id_categoria_nivel2->OldValue = "";
?>
</select>
<script type="text/javascript">
favisos_categoriasgrid.Lists["x_id_categoria_nivel2"].Options = <?php echo (is_array($avisos_categorias->id_categoria_nivel2->EditValue)) ? ew_ArrayToJson($avisos_categorias->id_categoria_nivel2->EditValue, 1) : "[]" ?>;
</script>
</span>
<input type="hidden" data-field="x_id_categoria_nivel2" name="o<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel2" id="o<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel2" value="<?php echo ew_HtmlEncode($avisos_categorias->id_categoria_nivel2->OldValue) ?>">
<?php } ?>
<?php if ($avisos_categorias->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $avisos_categorias_grid->RowCnt ?>_avisos_categorias_id_categoria_nivel2" class="form-group avisos_categorias_id_categoria_nivel2">
<select data-field="x_id_categoria_nivel2" id="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel2" name="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel2"<?php echo $avisos_categorias->id_categoria_nivel2->EditAttributes() ?>>
<?php
if (is_array($avisos_categorias->id_categoria_nivel2->EditValue)) {
	$arwrk = $avisos_categorias->id_categoria_nivel2->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($avisos_categorias->id_categoria_nivel2->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $avisos_categorias->id_categoria_nivel2->OldValue = "";
?>
</select>
<script type="text/javascript">
favisos_categoriasgrid.Lists["x_id_categoria_nivel2"].Options = <?php echo (is_array($avisos_categorias->id_categoria_nivel2->EditValue)) ? ew_ArrayToJson($avisos_categorias->id_categoria_nivel2->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php } ?>
<?php if ($avisos_categorias->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $avisos_categorias->id_categoria_nivel2->ViewAttributes() ?>>
<?php echo $avisos_categorias->id_categoria_nivel2->ListViewValue() ?></span>
<input type="hidden" data-field="x_id_categoria_nivel2" name="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel2" id="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel2" value="<?php echo ew_HtmlEncode($avisos_categorias->id_categoria_nivel2->FormValue) ?>">
<input type="hidden" data-field="x_id_categoria_nivel2" name="o<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel2" id="o<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel2" value="<?php echo ew_HtmlEncode($avisos_categorias->id_categoria_nivel2->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$avisos_categorias_grid->ListOptions->Render("body", "right", $avisos_categorias_grid->RowCnt);
?>
	</tr>
<?php if ($avisos_categorias->RowType == EW_ROWTYPE_ADD || $avisos_categorias->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
favisos_categoriasgrid.UpdateOpts(<?php echo $avisos_categorias_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($avisos_categorias->CurrentAction <> "gridadd" || $avisos_categorias->CurrentMode == "copy")
		if (!$avisos_categorias_grid->Recordset->EOF) $avisos_categorias_grid->Recordset->MoveNext();
}
?>
<?php
	if ($avisos_categorias->CurrentMode == "add" || $avisos_categorias->CurrentMode == "copy" || $avisos_categorias->CurrentMode == "edit") {
		$avisos_categorias_grid->RowIndex = '$rowindex$';
		$avisos_categorias_grid->LoadDefaultValues();

		// Set row properties
		$avisos_categorias->ResetAttrs();
		$avisos_categorias->RowAttrs = array_merge($avisos_categorias->RowAttrs, array('data-rowindex'=>$avisos_categorias_grid->RowIndex, 'id'=>'r0_avisos_categorias', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($avisos_categorias->RowAttrs["class"], "ewTemplate");
		$avisos_categorias->RowType = EW_ROWTYPE_ADD;

		// Render row
		$avisos_categorias_grid->RenderRow();

		// Render list options
		$avisos_categorias_grid->RenderListOptions();
		$avisos_categorias_grid->StartRowCnt = 0;
?>
	<tr<?php echo $avisos_categorias->RowAttributes() ?>>
<?php

// Render list options (body, left)
$avisos_categorias_grid->ListOptions->Render("body", "left", $avisos_categorias_grid->RowIndex);
?>
	<?php if ($avisos_categorias->id_categoria_nivel1->Visible) { // id_categoria_nivel1 ?>
		<td data-name="id_categoria_nivel1">
<?php if ($avisos_categorias->CurrentAction <> "F") { ?>
<span id="el$rowindex$_avisos_categorias_id_categoria_nivel1" class="form-group avisos_categorias_id_categoria_nivel1">
<?php $avisos_categorias->id_categoria_nivel1->EditAttrs["onchange"] = "ew_UpdateOpt.call(this, ['x" . $avisos_categorias_grid->RowIndex . "_id_categoria_nivel2']); " . @$avisos_categorias->id_categoria_nivel1->EditAttrs["onchange"]; ?>
<select data-field="x_id_categoria_nivel1" id="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel1" name="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel1"<?php echo $avisos_categorias->id_categoria_nivel1->EditAttributes() ?>>
<?php
if (is_array($avisos_categorias->id_categoria_nivel1->EditValue)) {
	$arwrk = $avisos_categorias->id_categoria_nivel1->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($avisos_categorias->id_categoria_nivel1->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $avisos_categorias->id_categoria_nivel1->OldValue = "";
?>
</select>
<script type="text/javascript">
favisos_categoriasgrid.Lists["x_id_categoria_nivel1"].Options = <?php echo (is_array($avisos_categorias->id_categoria_nivel1->EditValue)) ? ew_ArrayToJson($avisos_categorias->id_categoria_nivel1->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_avisos_categorias_id_categoria_nivel1" class="form-group avisos_categorias_id_categoria_nivel1">
<span<?php echo $avisos_categorias->id_categoria_nivel1->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $avisos_categorias->id_categoria_nivel1->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_id_categoria_nivel1" name="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel1" id="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel1" value="<?php echo ew_HtmlEncode($avisos_categorias->id_categoria_nivel1->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_id_categoria_nivel1" name="o<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel1" id="o<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel1" value="<?php echo ew_HtmlEncode($avisos_categorias->id_categoria_nivel1->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($avisos_categorias->id_categoria_nivel2->Visible) { // id_categoria_nivel2 ?>
		<td data-name="id_categoria_nivel2">
<?php if ($avisos_categorias->CurrentAction <> "F") { ?>
<span id="el$rowindex$_avisos_categorias_id_categoria_nivel2" class="form-group avisos_categorias_id_categoria_nivel2">
<select data-field="x_id_categoria_nivel2" id="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel2" name="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel2"<?php echo $avisos_categorias->id_categoria_nivel2->EditAttributes() ?>>
<?php
if (is_array($avisos_categorias->id_categoria_nivel2->EditValue)) {
	$arwrk = $avisos_categorias->id_categoria_nivel2->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($avisos_categorias->id_categoria_nivel2->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $avisos_categorias->id_categoria_nivel2->OldValue = "";
?>
</select>
<script type="text/javascript">
favisos_categoriasgrid.Lists["x_id_categoria_nivel2"].Options = <?php echo (is_array($avisos_categorias->id_categoria_nivel2->EditValue)) ? ew_ArrayToJson($avisos_categorias->id_categoria_nivel2->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_avisos_categorias_id_categoria_nivel2" class="form-group avisos_categorias_id_categoria_nivel2">
<span<?php echo $avisos_categorias->id_categoria_nivel2->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $avisos_categorias->id_categoria_nivel2->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_id_categoria_nivel2" name="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel2" id="x<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel2" value="<?php echo ew_HtmlEncode($avisos_categorias->id_categoria_nivel2->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_id_categoria_nivel2" name="o<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel2" id="o<?php echo $avisos_categorias_grid->RowIndex ?>_id_categoria_nivel2" value="<?php echo ew_HtmlEncode($avisos_categorias->id_categoria_nivel2->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$avisos_categorias_grid->ListOptions->Render("body", "right", $avisos_categorias_grid->RowCnt);
?>
<script type="text/javascript">
favisos_categoriasgrid.UpdateOpts(<?php echo $avisos_categorias_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($avisos_categorias->CurrentMode == "add" || $avisos_categorias->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $avisos_categorias_grid->FormKeyCountName ?>" id="<?php echo $avisos_categorias_grid->FormKeyCountName ?>" value="<?php echo $avisos_categorias_grid->KeyCount ?>">
<?php echo $avisos_categorias_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($avisos_categorias->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $avisos_categorias_grid->FormKeyCountName ?>" id="<?php echo $avisos_categorias_grid->FormKeyCountName ?>" value="<?php echo $avisos_categorias_grid->KeyCount ?>">
<?php echo $avisos_categorias_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($avisos_categorias->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="favisos_categoriasgrid">
</div>
<?php

// Close recordset
if ($avisos_categorias_grid->Recordset)
	$avisos_categorias_grid->Recordset->Close();
?>
<?php if ($avisos_categorias_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($avisos_categorias_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($avisos_categorias_grid->TotalRecs == 0 && $avisos_categorias->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($avisos_categorias_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($avisos_categorias->Export == "") { ?>
<script type="text/javascript">
favisos_categoriasgrid.Init();
</script>
<?php } ?>
<?php
$avisos_categorias_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$avisos_categorias_grid->Page_Terminate();
?>
