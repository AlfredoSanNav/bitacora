# DEMO APLICACION FEDERADA CON SIMPLESAML

_Código basico de php que permite conocer el funcionamiento e implementación de la identidad federada_

## Comenzando 🚀

_Descargue este proyecto en una carpeta web de su servidor_



### Pre-requisitos 📋

_Se requiere tener simplesamlphp ya instalado y configurado y conocer la ruta de instalación, que servirá de base para incluir la librería_

```
/var/simplesamlphp/
```

### Configuracion 🔧

_Abra el archivo config.php y ajuste los datos para que coincidan con su entorno de desarrollo_


_Ruta de la librería_
```
$saml_lib_path = '/path/to/simplesamlphp/lib/_autoload.php';
```

_Url completa de la aplicación_

```
$SP_URL = 'https://'.$_SERVER['SERVER_NAME']."/demo/";
```

_Source a utilizar (configurado en simplesamlphp)_

```
$SP_ORIGEN= 'default-sp'; 
```


## Construido con 🛠️

_Se requiere SIMPLESAMLphp instalado y configurado_

* [Simplesamlphp](https://simplesamlphp.org/) - Página oficial
* [Descarga](https://simplesamlphp.org/download?latest) - Última versión
* [Documentacion](https://simplesamlphp.org/docs/stable/)

## Más información :fa-info-circle: 

_Federación de Identidades de la Universidad de Colima_

* [Federación UCOL](https://portal.ucol.mx/federacion-identidades/) - Página oficial
