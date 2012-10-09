<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Scaffolds
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="row">
<div class="span2 bs-docs-sidebar">
	<ul class="nav nav-list bs-docs-sidenav">
		<li><?php echo $this->Html->link(__d('cake', 'New %s', $singularHumanName), array('action' => 'add')); ?></li>
<?php
		$done = array();
		foreach ($associations as $_type => $_data) {
			foreach ($_data as $_alias => $_details) {
				if ($_details['controller'] != $this->name && !in_array($_details['controller'], $done)) {
					echo "<li>" . $this->Html->link(__d('cake', 'List %s', Inflector::humanize($_details['controller'])), array('controller' => $_details['controller'], 'action' => 'index')) . "</li>";
					echo "<li>" . $this->Html->link(__d('cake', 'New %s', Inflector::humanize(Inflector::underscore($_alias))), array('controller' => $_details['controller'], 'action' => 'add')) . "</li>";
					$done[] = $_details['controller'];
				}
			}
		}
?>
	</ul>
</div>

<div class="span10 <?php echo $pluralVar; ?> index">
<h2><?php echo $pluralHumanName; ?></h2>
<table class="table table-bordered table-condensed table-hover table-stripped">
<thead>
<tr>
<?php foreach ($scaffoldFields as $_field): ?>
	<th><?php echo $this->Paginator->sort($_field); ?></th>
<?php endforeach; ?>
	<th><?php echo __d('cake', 'Actions'); ?></th>
</tr>
</thead>
<?php
$i = 0;
foreach (${$pluralVar} as ${$singularVar}):
	echo "<tr>";
		foreach ($scaffoldFields as $_field) {
			$isKey = false;
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $_alias => $_details) {
					if ($_field === $_details['foreignKey']) {
						$isKey = true;
						echo "<td>" . $this->Html->link(${$singularVar}[$_alias][$_details['displayField']], array('controller' => $_details['controller'], 'action' => 'view', ${$singularVar}[$_alias][$_details['primaryKey']])) . "</td>";
						break;
					}
				}
			}
			if ($isKey !== true) {
				echo "<td>" . h(${$singularVar}[$modelClass][$_field]) . "</td>";
			}
		}

		echo '<td class="actions"><div class="btn-group">';
		echo $this->Html->link('<i class="icon-cog"></i> ' . __('Action') . ' <span class="caret"></span>', '#', array('class' => 'btn dropdown-toggle', 'data-toggle' => 'dropdown', 'escape' => false));
  		echo '<ul class="dropdown-menu">';
		echo '<li>';
		echo $this->Html->link('<i class="icon-eye-open"></i> ' . __d('cake', 'View'), array('action' => 'view', ${$singularVar}[$modelClass][$primaryKey]), array('escape' => false));
		echo '</li><li>';
		echo $this->Html->link('<i class="icon-pencil"></i> ' . __d('cake', 'Edit'), array('action' => 'edit', ${$singularVar}[$modelClass][$primaryKey]), array('escape' => false));
		echo '</li><li>';
		echo $this->Form->postLink(
			'<i class="icon-trash"></i> ' . __d('cake', 'Delete'),
			array('action' => 'delete', ${$singularVar}[$modelClass][$primaryKey]),
			array('escape' => false),
			__d('cake', 'Are you sure you want to delete').' #' . ${$singularVar}[$modelClass][$primaryKey]
		);
		echo '</li>';
		echo '</ul></div></td>';
	echo '</tr>';

endforeach;

?>
</table>
	<p><?php
	echo $this->Paginator->counter(array(
		'format' => __d('cake', 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?></p>
	<div class="pagination">
		<ul>
	<?php
		echo $this->Paginator->prev('«', array('tag' => 'li'), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentClass' => 'active'));
		echo $this->Paginator->next('»', array('tag' => 'li'), null, array('class' => 'next disabled'));
	?>
		</ul>
	</div>
</div>
</div>