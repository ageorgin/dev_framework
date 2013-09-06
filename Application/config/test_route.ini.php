[mapping_url_statique]
url_pattern.test = "/test"
url_pattern.aaa = "/pouet"
url_script.test.module = "Test"
url_script.test.controller = "Test"
url_script.test.action = "test"

[mapping_url_dynamique]
url_dynamique_pattern.edit_user = "/user/id/*"
url_dynamique_pattern.edit_user_profile = "/user/id/*/profil"
url_dynamique_script.edit_user.module = "Test"
url_dynamique_script.edit_user.controller = "Test"
url_dynamique_script.edit_user.action = "editUser"
url_dynamique_script.edit_user.param1 = "id"
url_dynamique_script.edit_user_profile.module = "Test"
url_dynamique_script.edit_user_profile.controller = "Test"
url_dynamique_script.edit_user_profile.action = "userProfile"

