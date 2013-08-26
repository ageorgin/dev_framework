[general]
site_url="http://tntsatrenouvellement-dev/~ageorgin"
paiement_url="http://tntsatrenouvellement-dev/~ageorgin"
path_prefix = "~ageorgin"

[database]
server=lcpphp
login=tntsatren
password=tntsatren
base=tntsatren_dev

[webservice_cgaweb]
url_wsdl_cgaweb="/wsdl/dev/PoseService.wsdl"
activer_securite=false
user_securite=test
password_securite=test

[webservice_pfs_qas]
url_wsdl_pfs_qas="/wsdl/dev/wsAppelQAS.wsdl"
activer_securite=false
user_securite=test
password_securite=test
niveau_retour_ok=0

[minify]
css_relative_path=css/minify
js_relative_path=js/minify
cache_time=0

[log]
log_level=4
log_path=""
log_filename=test.log

[omniture]
param_omniture_1=cplusglobaldev
param_omniture_2=cplustntsatdev
channel=TNTsatrenouvellement