[general]
site_url="http://renouvellementcarte.tntsat.tv"
paiement_url="https://secure.tntsat.tv"
path_prefix = ""

[database]
server=cplmsq-cms-s01
login=a23
password=bh67jazGk0
base=p4f

[webservice_cgaweb]
url_wsdl_cgaweb="/wsdl/prod/PoseService.wsdl"
activer_securite=true
user_securite=tntsat
password_securite=7zmzTtq

[webservice_pfs_qas]
url_wsdl_pfs_qas="/wsdl/prod/wsAppelQAS.wsdl"
activer_securite=true
user_securite=tntsat
password_securite=7zmzTtq
niveau_retour_ok=0

[minify]
css_relative_path=css/minify
js_relative_path=js/minify
cache_time=0

[log]
log_level=3
log_path=""
log_filename=tntsat-renouvellement.log

[omniture]
param_omniture_1=cplusglobalprod
param_omniture_2=cplustntsatprod
channel=TNTsatrenouvellement