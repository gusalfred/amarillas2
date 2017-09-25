<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg11.php" ?>
<?php include_once "ewmysql11.php" ?>
<?php include_once "phpfn11.php" ?>
<?php include_once "avisos_categorias_info.php" ?>
<?php include_once "avisos_info.php" ?>
<?php include_once "empleados_info.php" ?>
<?php include_once "userfn11.php" ?>
<?php

//
// Page class
//

$avisos_categorias_list = NULL; // Initialize page object first

class cavisos_categorias_list extends cavisos_categorias {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{D02329FA-C783-46FA-A3B4-996FD9449799}";

	// Table name
	var $TableName = 'avisos_categorias';

	// Page object name
	var $PageObjName = 'avisos_categorias_list';

	// Grid form hidden field names
	var $FormName = 'favisos_categoriaslist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME]);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (avisos_categorias)
		if (!isset($GLOBALS["avisos_categorias"]) || get_class($GLOBALS["avisos_categorias"]) == "cavisos_categorias") {
			$GLOBALS["avisos_categorias"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["avisos_categorias"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "avisos_categorias_add.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "avisos_categorias_delete.php";
		$this->MultiUpdateUrl = "avisos_categorias_update.php";

		// Table object (avisos)
		if (!isset($GLOBALS['avisos'])) $GLOBALS['avisos'] = new cavisos();

		// Table object (empleados)
		if (!isset($GLOBALS['empleados'])) $GLOBALS['empleados'] = new cempleados();

		// User table object (empleados)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cempleados();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'avisos_categorias', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (IsPasswordExpired())
			$this->Page_Terminate(ew_GetUrl("changepwd.php"));
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		$Security->TablePermission_Loaded();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}

		// Update last accessed time
		if ($UserProfile->IsValidUser(CurrentUserName(), session_id())) {
		} else {
			echo $Language->Phrase("UserProfileCorrupted");
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
		}

		// Create Token
		$this->CreateToken();

		// Setup other options
		$this->SetupOtherOptions();

		// Set "checkbox" visible
		if (count($this->CustomActions) > 0)
			$this->ListOptions->Items["checkbox"]->Visible = TRUE;
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn, $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $avisos_categorias;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($avisos_categorias);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process custom action first
			$this->ProcessCustomAction();

			// Handle reset command
			$this->ResetCmd();

			// Set up master detail parameters
			$this->SetUpMasterParms();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($this->CurrentAction == "add" || $this->CurrentAction == "copy")
					$this->InlineAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($this->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();
				}
			}

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide export options
			if ($this->Export <> "" || $this->CurrentAction <> "")
				$this->ExportOptions->HideAllOptions();

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "avisos") {
			global $avisos;
			$rsmaster = $avisos->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("avisos_list.php"); // Return to master page
			} else {
				$avisos->LoadListRowValues($rsmaster);
				$avisos->RowType = EW_ROWTYPE_MASTER; // Master row
				$avisos->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = EW_SELECT_LIMIT;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	//  Exit inline mode
	function ClearInlineMode() {
		$this->setKey("id_aviso_categoria", ""); // Clear inline edit key
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $Language;
		if (!$Security->CanEdit())
			$this->Page_Terminate("login.php"); // Go to login page
		$bInlineEdit = TRUE;
		if (@$_GET["id_aviso_categoria"] <> "") {
			$this->id_aviso_categoria->setQueryStringValue($_GET["id_aviso_categoria"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("id_aviso_categoria", $this->id_aviso_categoria->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError;
		$objForm->Index = 1; 
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {	
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setFailureMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			if ($this->SetupKeyValues($rowkey)) { // Set up key values
				if ($this->CheckInlineEditKey()) { // Check key
					$this->SendEmail = TRUE; // Send email on update success
					$bInlineUpdate = $this->EditRow(); // Update record
				} else {
					$bInlineUpdate = FALSE;
				}
			}
		}
		if ($bInlineUpdate) { // Update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Cancel event
			$this->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {

		//CheckInlineEditKey = True
		if (strval($this->getKey("id_aviso_categoria")) <> strval($this->id_aviso_categoria->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $Language;
		if (!$Security->CanAdd())
			$this->Page_Terminate("login.php"); // Return to login page
		$this->CurrentAction = "add";
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError;
		$this->LoadOldRecord(); // Load old recordset
		$objForm->Index = 0;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setFailureMessage($gsFormError); // Set validation error message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$this->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow($this->OldRecordset)) { // Add record
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->id_aviso_categoria->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id_aviso_categoria->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->id_categoria_nivel1); // id_categoria_nivel1
			$this->UpdateSort($this->id_categoria_nivel2); // id_categoria_nivel2
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->id_aviso->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->id_categoria_nivel1->setSort("");
				$this->id_categoria_nivel2->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = FALSE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanAdd() && ($this->CurrentAction == "add");
		$item->OnLeft = FALSE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if (($this->CurrentAction == "add" || $this->CurrentAction == "copy") && $this->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a class=\"ewGridLink ewInlineInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit();\">" . $Language->Phrase("InsertLink") . "</a>&nbsp;" .
				"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink ewInlineUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->id_aviso_categoria->CurrentValue) . "\">";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" href=\"" . ew_HtmlEncode(ew_GetHashUrl($this->InlineEditUrl, $this->PageObjName . "_row_" . $this->RowCnt)) . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete())
			$oListOpt->Body = "<a class=\"ewRowLink ewDelete\"" . "" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		else
			$oListOpt->Body = "";

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->id_aviso_categoria->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event, this);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Inline Add
		$item = &$option->Add("inlineadd");
		$item->Body = "<a class=\"ewAddEdit ewInlineAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineAddUrl) . "\">" .$Language->Phrase("InlineAddLink") . "</a>";
		$item->Visible = ($this->InlineAddUrl <> "" && $Security->CanAdd());
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];
			foreach ($this->CustomActions as $action => $name) {

				// Add custom action
				$item = &$option->Add("custom_" . $action);
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.favisos_categoriaslist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
			}

			// Hide grid edit, multi-delete and multi-update
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$item = &$option->GetItem("multidelete");
				if ($item) $item->Visible = FALSE;
				$item = &$option->GetItem("multiupdate");
				if ($item) $item->Visible = FALSE;
			}
	}

	// Process custom action
	function ProcessCustomAction() {
		global $conn, $Language, $Security;
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$rsuser = ($rs) ? $rs->GetRows() : array();
			if ($rs)
				$rs->Close();

			// Call row custom action event
			if (count($rsuser) > 0) {
				$conn->BeginTrans();
				foreach ($rsuser as $row) {
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $UserAction, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $UserAction, $Language->Phrase("CustomActionCancelled")));
					}
				}
			}
		}
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch())
			$this->SearchOptions->HideAllOptions();
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Load default values
	function LoadDefaultValues() {
		$this->id_categoria_nivel1->CurrentValue = NULL;
		$this->id_categoria_nivel1->OldValue = $this->id_categoria_nivel1->CurrentValue;
		$this->id_categoria_nivel2->CurrentValue = NULL;
		$this->id_categoria_nivel2->OldValue = $this->id_categoria_nivel2->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id_categoria_nivel1->FldIsDetailKey) {
			$this->id_categoria_nivel1->setFormValue($objForm->GetValue("x_id_categoria_nivel1"));
		}
		if (!$this->id_categoria_nivel2->FldIsDetailKey) {
			$this->id_categoria_nivel2->setFormValue($objForm->GetValue("x_id_categoria_nivel2"));
		}
		if (!$this->id_aviso_categoria->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id_aviso_categoria->setFormValue($objForm->GetValue("x_id_aviso_categoria"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id_aviso_categoria->CurrentValue = $this->id_aviso_categoria->FormValue;
		$this->id_categoria_nivel1->CurrentValue = $this->id_categoria_nivel1->FormValue;
		$this->id_categoria_nivel2->CurrentValue = $this->id_categoria_nivel2->FormValue;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn;

		// Load List page SQL
		$sSql = $this->SelectSQL();

		// Load recordset
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->id_aviso_categoria->setDbValue($rs->fields('id_aviso_categoria'));
		$this->id_aviso->setDbValue($rs->fields('id_aviso'));
		$this->id_categoria_nivel1->setDbValue($rs->fields('id_categoria_nivel1'));
		$this->id_categoria_nivel2->setDbValue($rs->fields('id_categoria_nivel2'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_aviso_categoria->DbValue = $row['id_aviso_categoria'];
		$this->id_aviso->DbValue = $row['id_aviso'];
		$this->id_categoria_nivel1->DbValue = $row['id_categoria_nivel1'];
		$this->id_categoria_nivel2->DbValue = $row['id_categoria_nivel2'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id_aviso_categoria")) <> "")
			$this->id_aviso_categoria->CurrentValue = $this->getKey("id_aviso_categoria"); // id_aviso_categoria
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id_aviso_categoria
		// id_aviso
		// id_categoria_nivel1
		// id_categoria_nivel2

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id_aviso_categoria
			$this->id_aviso_categoria->ViewValue = $this->id_aviso_categoria->CurrentValue;
			$this->id_aviso_categoria->ViewCustomAttributes = "";

			// id_aviso
			$this->id_aviso->ViewValue = $this->id_aviso->CurrentValue;
			$this->id_aviso->ViewCustomAttributes = "";

			// id_categoria_nivel1
			if (strval($this->id_categoria_nivel1->CurrentValue) <> "") {
				$sFilterWrk = "`id_categoria_nivel1`" . ew_SearchString("=", $this->id_categoria_nivel1->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `id_categoria_nivel1`, `categoria` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `categorias_nivel1`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->id_categoria_nivel1, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `categoria`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->id_categoria_nivel1->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->id_categoria_nivel1->ViewValue = $this->id_categoria_nivel1->CurrentValue;
				}
			} else {
				$this->id_categoria_nivel1->ViewValue = NULL;
			}
			$this->id_categoria_nivel1->ViewCustomAttributes = "";

			// id_categoria_nivel2
			if (strval($this->id_categoria_nivel2->CurrentValue) <> "") {
				$sFilterWrk = "`id_categoria_nivel2`" . ew_SearchString("=", $this->id_categoria_nivel2->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `id_categoria_nivel2`, `categoria` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `categorias_nivel2`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->id_categoria_nivel2, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `categoria`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->id_categoria_nivel2->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->id_categoria_nivel2->ViewValue = $this->id_categoria_nivel2->CurrentValue;
				}
			} else {
				$this->id_categoria_nivel2->ViewValue = NULL;
			}
			$this->id_categoria_nivel2->ViewCustomAttributes = "";

			// id_categoria_nivel1
			$this->id_categoria_nivel1->LinkCustomAttributes = "";
			$this->id_categoria_nivel1->HrefValue = "";
			$this->id_categoria_nivel1->TooltipValue = "";

			// id_categoria_nivel2
			$this->id_categoria_nivel2->LinkCustomAttributes = "";
			$this->id_categoria_nivel2->HrefValue = "";
			$this->id_categoria_nivel2->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// id_categoria_nivel1
			$this->id_categoria_nivel1->EditAttrs["class"] = "form-control";
			$this->id_categoria_nivel1->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `id_categoria_nivel1`, `categoria` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `categorias_nivel1`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->id_categoria_nivel1, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `categoria`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->id_categoria_nivel1->EditValue = $arwrk;

			// id_categoria_nivel2
			$this->id_categoria_nivel2->EditAttrs["class"] = "form-control";
			$this->id_categoria_nivel2->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `id_categoria_nivel2`, `categoria` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `id_categoria_nivel1` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `categorias_nivel2`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->id_categoria_nivel2, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `categoria`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->id_categoria_nivel2->EditValue = $arwrk;

			// Edit refer script
			// id_categoria_nivel1

			$this->id_categoria_nivel1->HrefValue = "";

			// id_categoria_nivel2
			$this->id_categoria_nivel2->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id_categoria_nivel1
			$this->id_categoria_nivel1->EditAttrs["class"] = "form-control";
			$this->id_categoria_nivel1->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `id_categoria_nivel1`, `categoria` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `categorias_nivel1`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->id_categoria_nivel1, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `categoria`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->id_categoria_nivel1->EditValue = $arwrk;

			// id_categoria_nivel2
			$this->id_categoria_nivel2->EditAttrs["class"] = "form-control";
			$this->id_categoria_nivel2->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `id_categoria_nivel2`, `categoria` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `id_categoria_nivel1` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `categorias_nivel2`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->id_categoria_nivel2, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `categoria`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->id_categoria_nivel2->EditValue = $arwrk;

			// Edit refer script
			// id_categoria_nivel1

			$this->id_categoria_nivel1->HrefValue = "";

			// id_categoria_nivel2
			$this->id_categoria_nivel2->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// id_categoria_nivel1
			$this->id_categoria_nivel1->SetDbValueDef($rsnew, $this->id_categoria_nivel1->CurrentValue, NULL, $this->id_categoria_nivel1->ReadOnly);

			// id_categoria_nivel2
			$this->id_categoria_nivel2->SetDbValueDef($rsnew, $this->id_categoria_nivel2->CurrentValue, NULL, $this->id_categoria_nivel2->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// id_categoria_nivel1
		$this->id_categoria_nivel1->SetDbValueDef($rsnew, $this->id_categoria_nivel1->CurrentValue, NULL, FALSE);

		// id_categoria_nivel2
		$this->id_categoria_nivel2->SetDbValueDef($rsnew, $this->id_categoria_nivel2->CurrentValue, NULL, FALSE);

		// id_aviso
		if ($this->id_aviso->getSessionValue() <> "") {
			$rsnew['id_aviso'] = $this->id_aviso->getSessionValue();
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$this->id_aviso_categoria->setDbValue($conn->Insert_ID());
			$rsnew['id_aviso_categoria'] = $this->id_aviso_categoria->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "avisos") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id_aviso"] <> "") {
					$GLOBALS["avisos"]->id_aviso->setQueryStringValue($_GET["fk_id_aviso"]);
					$this->id_aviso->setQueryStringValue($GLOBALS["avisos"]->id_aviso->QueryStringValue);
					$this->id_aviso->setSessionValue($this->id_aviso->QueryStringValue);
					if (!is_numeric($GLOBALS["avisos"]->id_aviso->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "avisos") {
				if ($this->id_aviso->QueryStringValue == "") $this->id_aviso->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

	    //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($avisos_categorias_list)) $avisos_categorias_list = new cavisos_categorias_list();

// Page init
$avisos_categorias_list->Page_Init();

// Page main
$avisos_categorias_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$avisos_categorias_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var avisos_categorias_list = new ew_Page("avisos_categorias_list");
avisos_categorias_list.PageID = "list"; // Page ID
var EW_PAGE_ID = avisos_categorias_list.PageID; // For backward compatibility

// Form object
var favisos_categoriaslist = new ew_Form("favisos_categoriaslist");
favisos_categoriaslist.FormKeyCountName = '<?php echo $avisos_categorias_list->FormKeyCountName ?>';

// Validate form
favisos_categoriaslist.Validate = function() {
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

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
favisos_categoriaslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
favisos_categoriaslist.ValidateRequired = true;
<?php } else { ?>
favisos_categoriaslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
favisos_categoriaslist.Lists["x_id_categoria_nivel1"] = {"LinkField":"x_id_categoria_nivel1","Ajax":null,"AutoFill":false,"DisplayFields":["x_categoria","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
favisos_categoriaslist.Lists["x_id_categoria_nivel2"] = {"LinkField":"x_id_categoria_nivel2","Ajax":null,"AutoFill":false,"DisplayFields":["x_categoria","","",""],"ParentFields":["x_id_categoria_nivel1"],"FilterFields":["x_id_categoria_nivel1"],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php if ($avisos_categorias_list->TotalRecs > 0 && $avisos_categorias_list->ExportOptions->Visible()) { ?>
<?php $avisos_categorias_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php if (($avisos_categorias->Export == "") || (EW_EXPORT_MASTER_RECORD && $avisos_categorias->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "avisos_list.php";
if ($avisos_categorias_list->DbMasterFilter <> "" && $avisos_categorias->getCurrentMasterTable() == "avisos") {
	if ($avisos_categorias_list->MasterRecordExists) {
		if ($avisos_categorias->getCurrentMasterTable() == $avisos_categorias->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php include_once "avisos_master.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		if ($avisos_categorias_list->TotalRecs <= 0)
			$avisos_categorias_list->TotalRecs = $avisos_categorias->SelectRecordCount();
	} else {
		if (!$avisos_categorias_list->Recordset && ($avisos_categorias_list->Recordset = $avisos_categorias_list->LoadRecordset()))
			$avisos_categorias_list->TotalRecs = $avisos_categorias_list->Recordset->RecordCount();
	}
	$avisos_categorias_list->StartRec = 1;
	if ($avisos_categorias_list->DisplayRecs <= 0 || ($avisos_categorias->Export <> "" && $avisos_categorias->ExportAll)) // Display all records
		$avisos_categorias_list->DisplayRecs = $avisos_categorias_list->TotalRecs;
	if (!($avisos_categorias->Export <> "" && $avisos_categorias->ExportAll))
		$avisos_categorias_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$avisos_categorias_list->Recordset = $avisos_categorias_list->LoadRecordset($avisos_categorias_list->StartRec-1, $avisos_categorias_list->DisplayRecs);

	// Set no record found message
	if ($avisos_categorias->CurrentAction == "" && $avisos_categorias_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$avisos_categorias_list->setWarningMessage($Language->Phrase("NoPermission"));
		if ($avisos_categorias_list->SearchWhere == "0=101")
			$avisos_categorias_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$avisos_categorias_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$avisos_categorias_list->RenderOtherOptions();
?>
<?php $avisos_categorias_list->ShowPageHeader(); ?>
<?php
$avisos_categorias_list->ShowMessage();
?>
<?php if ($avisos_categorias_list->TotalRecs > 0 || $avisos_categorias->CurrentAction <> "") { ?>
<div class="ewGrid">
<div class="ewGridUpperPanel">
<?php if ($avisos_categorias->CurrentAction <> "gridadd" && $avisos_categorias->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($avisos_categorias_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<form name="favisos_categoriaslist" id="favisos_categoriaslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($avisos_categorias_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $avisos_categorias_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="avisos_categorias">
<div id="gmp_avisos_categorias" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($avisos_categorias_list->TotalRecs > 0 || $avisos_categorias->CurrentAction == "add" || $avisos_categorias->CurrentAction == "copy") { ?>
<table id="tbl_avisos_categoriaslist" class="table ewTable">
<?php echo $avisos_categorias->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$avisos_categorias->RowType = EW_ROWTYPE_HEADER;

// Render list options
$avisos_categorias_list->RenderListOptions();

// Render list options (header, left)
$avisos_categorias_list->ListOptions->Render("header", "left");
?>
<?php if ($avisos_categorias->id_categoria_nivel1->Visible) { // id_categoria_nivel1 ?>
	<?php if ($avisos_categorias->SortUrl($avisos_categorias->id_categoria_nivel1) == "") { ?>
		<th data-name="id_categoria_nivel1"><div id="elh_avisos_categorias_id_categoria_nivel1" class="avisos_categorias_id_categoria_nivel1"><div class="ewTableHeaderCaption"><?php echo $avisos_categorias->id_categoria_nivel1->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id_categoria_nivel1"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $avisos_categorias->SortUrl($avisos_categorias->id_categoria_nivel1) ?>',1);"><div id="elh_avisos_categorias_id_categoria_nivel1" class="avisos_categorias_id_categoria_nivel1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $avisos_categorias->id_categoria_nivel1->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($avisos_categorias->id_categoria_nivel1->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($avisos_categorias->id_categoria_nivel1->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($avisos_categorias->id_categoria_nivel2->Visible) { // id_categoria_nivel2 ?>
	<?php if ($avisos_categorias->SortUrl($avisos_categorias->id_categoria_nivel2) == "") { ?>
		<th data-name="id_categoria_nivel2"><div id="elh_avisos_categorias_id_categoria_nivel2" class="avisos_categorias_id_categoria_nivel2"><div class="ewTableHeaderCaption"><?php echo $avisos_categorias->id_categoria_nivel2->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id_categoria_nivel2"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $avisos_categorias->SortUrl($avisos_categorias->id_categoria_nivel2) ?>',1);"><div id="elh_avisos_categorias_id_categoria_nivel2" class="avisos_categorias_id_categoria_nivel2">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $avisos_categorias->id_categoria_nivel2->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($avisos_categorias->id_categoria_nivel2->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($avisos_categorias->id_categoria_nivel2->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$avisos_categorias_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($avisos_categorias->CurrentAction == "add" || $avisos_categorias->CurrentAction == "copy") {
		$avisos_categorias_list->RowIndex = 0;
		$avisos_categorias_list->KeyCount = $avisos_categorias_list->RowIndex;
		if ($avisos_categorias->CurrentAction == "add")
			$avisos_categorias_list->LoadDefaultValues();
		if ($avisos_categorias->EventCancelled) // Insert failed
			$avisos_categorias_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$avisos_categorias->ResetAttrs();
		$avisos_categorias->RowAttrs = array_merge($avisos_categorias->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_avisos_categorias', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$avisos_categorias->RowType = EW_ROWTYPE_ADD;

		// Render row
		$avisos_categorias_list->RenderRow();

		// Render list options
		$avisos_categorias_list->RenderListOptions();
		$avisos_categorias_list->StartRowCnt = 0;
?>
	<tr<?php echo $avisos_categorias->RowAttributes() ?>>
<?php

// Render list options (body, left)
$avisos_categorias_list->ListOptions->Render("body", "left", $avisos_categorias_list->RowCnt);
?>
	<?php if ($avisos_categorias->id_categoria_nivel1->Visible) { // id_categoria_nivel1 ?>
		<td data-name="id_categoria_nivel1">
<span id="el<?php echo $avisos_categorias_list->RowCnt ?>_avisos_categorias_id_categoria_nivel1" class="form-group avisos_categorias_id_categoria_nivel1">
<?php $avisos_categorias->id_categoria_nivel1->EditAttrs["onchange"] = "ew_UpdateOpt.call(this, ['x" . $avisos_categorias_list->RowIndex . "_id_categoria_nivel2']); " . @$avisos_categorias->id_categoria_nivel1->EditAttrs["onchange"]; ?>
<select data-field="x_id_categoria_nivel1" id="x<?php echo $avisos_categorias_list->RowIndex ?>_id_categoria_nivel1" name="x<?php echo $avisos_categorias_list->RowIndex ?>_id_categoria_nivel1"<?php echo $avisos_categorias->id_categoria_nivel1->EditAttributes() ?>>
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
?>
</select>
<script type="text/javascript">
favisos_categoriaslist.Lists["x_id_categoria_nivel1"].Options = <?php echo (is_array($avisos_categorias->id_categoria_nivel1->EditValue)) ? ew_ArrayToJson($avisos_categorias->id_categoria_nivel1->EditValue, 1) : "[]" ?>;
</script>
</span>
<input type="hidden" data-field="x_id_categoria_nivel1" name="o<?php echo $avisos_categorias_list->RowIndex ?>_id_categoria_nivel1" id="o<?php echo $avisos_categorias_list->RowIndex ?>_id_categoria_nivel1" value="<?php echo ew_HtmlEncode($avisos_categorias->id_categoria_nivel1->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($avisos_categorias->id_categoria_nivel2->Visible) { // id_categoria_nivel2 ?>
		<td data-name="id_categoria_nivel2">
<span id="el<?php echo $avisos_categorias_list->RowCnt ?>_avisos_categorias_id_categoria_nivel2" class="form-group avisos_categorias_id_categoria_nivel2">
<select data-field="x_id_categoria_nivel2" id="x<?php echo $avisos_categorias_list->RowIndex ?>_id_categoria_nivel2" name="x<?php echo $avisos_categorias_list->RowIndex ?>_id_categoria_nivel2"<?php echo $avisos_categorias->id_categoria_nivel2->EditAttributes() ?>>
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
?>
</select>
<script type="text/javascript">
favisos_categoriaslist.Lists["x_id_categoria_nivel2"].Options = <?php echo (is_array($avisos_categorias->id_categoria_nivel2->EditValue)) ? ew_ArrayToJson($avisos_categorias->id_categoria_nivel2->EditValue, 1) : "[]" ?>;
</script>
</span>
<input type="hidden" data-field="x_id_categoria_nivel2" name="o<?php echo $avisos_categorias_list->RowIndex ?>_id_categoria_nivel2" id="o<?php echo $avisos_categorias_list->RowIndex ?>_id_categoria_nivel2" value="<?php echo ew_HtmlEncode($avisos_categorias->id_categoria_nivel2->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$avisos_categorias_list->ListOptions->Render("body", "right", $avisos_categorias_list->RowCnt);
?>
<script type="text/javascript">
favisos_categoriaslist.UpdateOpts(<?php echo $avisos_categorias_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($avisos_categorias->ExportAll && $avisos_categorias->Export <> "") {
	$avisos_categorias_list->StopRec = $avisos_categorias_list->TotalRecs;
} else {

	// Set the last record to display
	if ($avisos_categorias_list->TotalRecs > $avisos_categorias_list->StartRec + $avisos_categorias_list->DisplayRecs - 1)
		$avisos_categorias_list->StopRec = $avisos_categorias_list->StartRec + $avisos_categorias_list->DisplayRecs - 1;
	else
		$avisos_categorias_list->StopRec = $avisos_categorias_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($avisos_categorias_list->FormKeyCountName) && ($avisos_categorias->CurrentAction == "gridadd" || $avisos_categorias->CurrentAction == "gridedit" || $avisos_categorias->CurrentAction == "F")) {
		$avisos_categorias_list->KeyCount = $objForm->GetValue($avisos_categorias_list->FormKeyCountName);
		$avisos_categorias_list->StopRec = $avisos_categorias_list->StartRec + $avisos_categorias_list->KeyCount - 1;
	}
}
$avisos_categorias_list->RecCnt = $avisos_categorias_list->StartRec - 1;
if ($avisos_categorias_list->Recordset && !$avisos_categorias_list->Recordset->EOF) {
	$avisos_categorias_list->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $avisos_categorias_list->StartRec > 1)
		$avisos_categorias_list->Recordset->Move($avisos_categorias_list->StartRec - 1);
} elseif (!$avisos_categorias->AllowAddDeleteRow && $avisos_categorias_list->StopRec == 0) {
	$avisos_categorias_list->StopRec = $avisos_categorias->GridAddRowCount;
}

// Initialize aggregate
$avisos_categorias->RowType = EW_ROWTYPE_AGGREGATEINIT;
$avisos_categorias->ResetAttrs();
$avisos_categorias_list->RenderRow();
$avisos_categorias_list->EditRowCnt = 0;
if ($avisos_categorias->CurrentAction == "edit")
	$avisos_categorias_list->RowIndex = 1;
while ($avisos_categorias_list->RecCnt < $avisos_categorias_list->StopRec) {
	$avisos_categorias_list->RecCnt++;
	if (intval($avisos_categorias_list->RecCnt) >= intval($avisos_categorias_list->StartRec)) {
		$avisos_categorias_list->RowCnt++;

		// Set up key count
		$avisos_categorias_list->KeyCount = $avisos_categorias_list->RowIndex;

		// Init row class and style
		$avisos_categorias->ResetAttrs();
		$avisos_categorias->CssClass = "";
		if ($avisos_categorias->CurrentAction == "gridadd") {
			$avisos_categorias_list->LoadDefaultValues(); // Load default values
		} else {
			$avisos_categorias_list->LoadRowValues($avisos_categorias_list->Recordset); // Load row values
		}
		$avisos_categorias->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($avisos_categorias->CurrentAction == "edit") {
			if ($avisos_categorias_list->CheckInlineEditKey() && $avisos_categorias_list->EditRowCnt == 0) { // Inline edit
				$avisos_categorias->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($avisos_categorias->CurrentAction == "edit" && $avisos_categorias->RowType == EW_ROWTYPE_EDIT && $avisos_categorias->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$avisos_categorias_list->RestoreFormValues(); // Restore form values
		}
		if ($avisos_categorias->RowType == EW_ROWTYPE_EDIT) // Edit row
			$avisos_categorias_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$avisos_categorias->RowAttrs = array_merge($avisos_categorias->RowAttrs, array('data-rowindex'=>$avisos_categorias_list->RowCnt, 'id'=>'r' . $avisos_categorias_list->RowCnt . '_avisos_categorias', 'data-rowtype'=>$avisos_categorias->RowType));

		// Render row
		$avisos_categorias_list->RenderRow();

		// Render list options
		$avisos_categorias_list->RenderListOptions();
?>
	<tr<?php echo $avisos_categorias->RowAttributes() ?>>
<?php

// Render list options (body, left)
$avisos_categorias_list->ListOptions->Render("body", "left", $avisos_categorias_list->RowCnt);
?>
	<?php if ($avisos_categorias->id_categoria_nivel1->Visible) { // id_categoria_nivel1 ?>
		<td data-name="id_categoria_nivel1"<?php echo $avisos_categorias->id_categoria_nivel1->CellAttributes() ?>>
<?php if ($avisos_categorias->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $avisos_categorias_list->RowCnt ?>_avisos_categorias_id_categoria_nivel1" class="form-group avisos_categorias_id_categoria_nivel1">
<?php $avisos_categorias->id_categoria_nivel1->EditAttrs["onchange"] = "ew_UpdateOpt.call(this, ['x" . $avisos_categorias_list->RowIndex . "_id_categoria_nivel2']); " . @$avisos_categorias->id_categoria_nivel1->EditAttrs["onchange"]; ?>
<select data-field="x_id_categoria_nivel1" id="x<?php echo $avisos_categorias_list->RowIndex ?>_id_categoria_nivel1" name="x<?php echo $avisos_categorias_list->RowIndex ?>_id_categoria_nivel1"<?php echo $avisos_categorias->id_categoria_nivel1->EditAttributes() ?>>
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
?>
</select>
<script type="text/javascript">
favisos_categoriaslist.Lists["x_id_categoria_nivel1"].Options = <?php echo (is_array($avisos_categorias->id_categoria_nivel1->EditValue)) ? ew_ArrayToJson($avisos_categorias->id_categoria_nivel1->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php } ?>
<?php if ($avisos_categorias->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $avisos_categorias->id_categoria_nivel1->ViewAttributes() ?>>
<?php echo $avisos_categorias->id_categoria_nivel1->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $avisos_categorias_list->PageObjName . "_row_" . $avisos_categorias_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($avisos_categorias->RowType == EW_ROWTYPE_EDIT || $avisos_categorias->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_id_aviso_categoria" name="x<?php echo $avisos_categorias_list->RowIndex ?>_id_aviso_categoria" id="x<?php echo $avisos_categorias_list->RowIndex ?>_id_aviso_categoria" value="<?php echo ew_HtmlEncode($avisos_categorias->id_aviso_categoria->CurrentValue) ?>">
<?php } ?>
	<?php if ($avisos_categorias->id_categoria_nivel2->Visible) { // id_categoria_nivel2 ?>
		<td data-name="id_categoria_nivel2"<?php echo $avisos_categorias->id_categoria_nivel2->CellAttributes() ?>>
<?php if ($avisos_categorias->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $avisos_categorias_list->RowCnt ?>_avisos_categorias_id_categoria_nivel2" class="form-group avisos_categorias_id_categoria_nivel2">
<select data-field="x_id_categoria_nivel2" id="x<?php echo $avisos_categorias_list->RowIndex ?>_id_categoria_nivel2" name="x<?php echo $avisos_categorias_list->RowIndex ?>_id_categoria_nivel2"<?php echo $avisos_categorias->id_categoria_nivel2->EditAttributes() ?>>
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
?>
</select>
<script type="text/javascript">
favisos_categoriaslist.Lists["x_id_categoria_nivel2"].Options = <?php echo (is_array($avisos_categorias->id_categoria_nivel2->EditValue)) ? ew_ArrayToJson($avisos_categorias->id_categoria_nivel2->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php } ?>
<?php if ($avisos_categorias->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $avisos_categorias->id_categoria_nivel2->ViewAttributes() ?>>
<?php echo $avisos_categorias->id_categoria_nivel2->ListViewValue() ?></span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$avisos_categorias_list->ListOptions->Render("body", "right", $avisos_categorias_list->RowCnt);
?>
	</tr>
<?php if ($avisos_categorias->RowType == EW_ROWTYPE_ADD || $avisos_categorias->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
favisos_categoriaslist.UpdateOpts(<?php echo $avisos_categorias_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	if ($avisos_categorias->CurrentAction <> "gridadd")
		$avisos_categorias_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($avisos_categorias->CurrentAction == "add" || $avisos_categorias->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $avisos_categorias_list->FormKeyCountName ?>" id="<?php echo $avisos_categorias_list->FormKeyCountName ?>" value="<?php echo $avisos_categorias_list->KeyCount ?>">
<?php } ?>
<?php if ($avisos_categorias->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $avisos_categorias_list->FormKeyCountName ?>" id="<?php echo $avisos_categorias_list->FormKeyCountName ?>" value="<?php echo $avisos_categorias_list->KeyCount ?>">
<?php } ?>
<?php if ($avisos_categorias->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($avisos_categorias_list->Recordset)
	$avisos_categorias_list->Recordset->Close();
?>
<div class="ewGridLowerPanel">
<?php if ($avisos_categorias->CurrentAction <> "gridadd" && $avisos_categorias->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($avisos_categorias_list->Pager)) $avisos_categorias_list->Pager = new cPrevNextPager($avisos_categorias_list->StartRec, $avisos_categorias_list->DisplayRecs, $avisos_categorias_list->TotalRecs) ?>
<?php if ($avisos_categorias_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($avisos_categorias_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $avisos_categorias_list->PageUrl() ?>start=<?php echo $avisos_categorias_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($avisos_categorias_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $avisos_categorias_list->PageUrl() ?>start=<?php echo $avisos_categorias_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $avisos_categorias_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($avisos_categorias_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $avisos_categorias_list->PageUrl() ?>start=<?php echo $avisos_categorias_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($avisos_categorias_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $avisos_categorias_list->PageUrl() ?>start=<?php echo $avisos_categorias_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $avisos_categorias_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $avisos_categorias_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $avisos_categorias_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $avisos_categorias_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($avisos_categorias_list->TotalRecs == 0 && $avisos_categorias->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($avisos_categorias_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
favisos_categoriaslist.Init();
</script>
<?php
$avisos_categorias_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$avisos_categorias_list->Page_Terminate();
?>
