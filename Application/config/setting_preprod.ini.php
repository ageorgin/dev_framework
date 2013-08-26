[general]
site_url="http://preprod-renouvellement-tntsat.canal-bis.com"
paiement_url="https://secure-preprod-renouvellement-tntsat.canal-bis.com"
path_prefix = ""

[database]
server=cplmsq-cms-s05-02.cinema.jmsp.net
login=tntsatren
password=s@Ttnt
base=tntsat_renouvellement

[webservice_cgaweb]
url_wsdl_cgaweb="/wsdl/preprod/PoseService.wsdl"
activer_securite=true
user_securite=tntsat
password_securite=smoo8M5z

[webservice_pfs_qas]
url_wsdl_pfs_qas="/wsdl/preprod/wsAppelQAS.wsdl"
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
param_omniture_1=cplusglobalpreprod
param_omniture_2=cplustntsatpreprod
channel=TNTsatrenouvellement