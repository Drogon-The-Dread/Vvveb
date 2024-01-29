import(common.tpl)

@roles-tab = [data-v-roles-tabs] [data-v-roles-tab]

@roles-tab|deleteAllButFirstChild

@roles-tab|before = <?php foreach ($this->roles as $roles => $settings) { 
	$enabled = isset($settings['enabled']) && $settings['enabled'] == 'true';
?>

	@roles-tab [data-v-roles-tab-name]  = <?php echo Vvveb\humanReadable($roles);?>
	@roles-tab [data-v-roles-tab-value] = $roles
	@roles-tab [data-v-roles-tab-link]|addClass = <?php if (!$enabled) echo 'd-none';?>
	@roles-tab [data-v-roles-tab-link]|data-bs-target = <?php echo '#' . $roles;?>
	@roles-tab [data-v-roles-tab-link]|id = <?php echo  $roles . '-tab';?>
	
	@roles-tab input[type="radio"]|addNewAttribute = <?php 
		$enabled = isset($settings['@@__name__@@']) && $settings['@@__name__@@'] == 'true';
		if (('@@__value__@@' == 'true' && $enabled) || 
			('@@__value__@@' == 'false' && !$enabled)) echo 'checked';
	?>
	@roles-tab [type="text"]|value = <?php echo $settings['@@__name__@@'] ?? '@@__value__@@';?>
	@roles-tab [data-v-roles-input]|name = <?php echo "settings[roles][$roles][@@__name__@@]";?>

@roles-tab|after = <?php } ?>

@roles-tab[data-v-roles-tab-pane]|id = $roles


@roles = [data-v-roles] [data-v-role]

@roles|deleteAllButFirst

@roles|before = <?php foreach ($this->roles as $roles => $settings) { ?>

	@roles [data-v-roles-name]  = <?php echo Vvveb\humanReadable($roles);?>
	@roles [data-v-roles-input]|data-roles = $roles
	@roles [data-v-roles-input]|addNewAttribute = <?php 
		$enabled = isset($settings['enabled']) && $settings['enabled'] == 'true';
		if (('@@__value__@@' == 'true' && $enabled) || 
			('@@__value__@@' == 'false' && !$enabled)) echo 'checked';
	?>
	@roles [data-v-roles-input]|name = <?php echo "settings[roles][$roles][enabled]";?>

@roles|after = <?php } ?>


#hide-menu-per-role .nav-link|href = <?php echo 'javascript:void();';?>

[data-v-submenu-item] .nav-link|prepend = '<input type="checkbox" class="form-check-input me-1" name=""/>';
