[general]
site_url="http://renouvellementcarte.tntsat.tv"
paiement_url="http://renouvellementcarte.tntsat.tv"
path_prefix = ""

[database]
server=
login=
password=
base=

[webservice_cgaweb]
url_wsdl_cgaweb="/wsdl/recette/PoseService.wsdl"
activer_securite=true
user_securite=tntsat
password_securite=smoo8M5z

[webservice_pfs_qas]
url_wsdl_pfs_qas="/wsdl/recette/wsAppelQAS.wsdl"
activer_securite=true
user_securite=tntsat
password_securite=smoo8M5z
niveau_retour_ok=0

[minify]
css_relative_path=css/minify
js_relative_path=js/minify
cache_time=0

[log]
log_level=4
log_path=""
log_filename=tntsat-renouvellement.log

[omniture]
param_omniture_1=cplusglobalprod
param_omniture_2=cplustntsatprod
channel=TNTsatrenouvellement