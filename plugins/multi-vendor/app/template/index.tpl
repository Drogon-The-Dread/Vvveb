import(common.tpl)

#signup-form|action = "/vendor-signup"
[data-v-url="user/login/index"]|href = "/admin"

input|value = <?php if (isset($_POST['@@__name__@@'])) echo $_POST['@@__name__@@'];?>
