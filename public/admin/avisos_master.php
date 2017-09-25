<?php

// fecha
// id_empresa
// nombre_aviso
// archivo

?>
<?php if ($avisos->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $avisos->TableCaption() ?></h4> -->
<table id="tbl_avisosmaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($avisos->fecha->Visible) { // fecha ?>
		<tr id="r_fecha">
			<td><?php echo $avisos->fecha->FldCaption() ?></td>
			<td<?php echo $avisos->fecha->CellAttributes() ?>>
<span id="el_avisos_fecha">
<span<?php echo $avisos->fecha->ViewAttributes() ?>>
<?php echo $avisos->fecha->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($avisos->id_empresa->Visible) { // id_empresa ?>
		<tr id="r_id_empresa">
			<td><?php echo $avisos->id_empresa->FldCaption() ?></td>
			<td<?php echo $avisos->id_empresa->CellAttributes() ?>>
<span id="el_avisos_id_empresa">
<span<?php echo $avisos->id_empresa->ViewAttributes() ?>>
<?php echo $avisos->id_empresa->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($avisos->nombre_aviso->Visible) { // nombre_aviso ?>
		<tr id="r_nombre_aviso">
			<td><?php echo $avisos->nombre_aviso->FldCaption() ?></td>
			<td<?php echo $avisos->nombre_aviso->CellAttributes() ?>>
<span id="el_avisos_nombre_aviso">
<span<?php echo $avisos->nombre_aviso->ViewAttributes() ?>>
<?php echo $avisos->nombre_aviso->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($avisos->archivo->Visible) { // archivo ?>
		<tr id="r_archivo">
			<td><?php echo $avisos->archivo->FldCaption() ?></td>
			<td<?php echo $avisos->archivo->CellAttributes() ?>>
<span id="el_avisos_archivo">
<span>
<?php echo ew_GetFileViewTag($avisos->archivo, $avisos->archivo->ListViewValue()) ?>
</span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
