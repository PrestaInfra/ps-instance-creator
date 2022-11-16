# ps-instance-creator
Prestashop docker instance creator

![image](https://user-images.githubusercontent.com/16455155/202083337-4cece137-1964-4582-aa4a-aea92a3d0eb6.png)

Instance summary before creation :
![image](https://user-images.githubusercontent.com/16455155/202085520-25b7214f-b8e5-41cc-9bfb-c57303905dab.png)


# Requirements :

- `yarn` >= 1.22.19
- `php` >= 8.1
- `docker`

# Install

- `git` clone https://github.com/PrestaInfra/ps-instance-creator.git
- `cd` ps-instance-creator
- `composer` install
- `yarn` install
- `php` -S localhost:9999


NOTE : Use releases for production version. See here https://github.com/PrestaInfra/ps-instance-creator/releases

# Config vars

See `config/parameters.yaml`

| Var                           | description                     | Default                                                                                        | Required |
|:------------------------------|:--------------------------------|:-----------------------------------------------------------------------------------------------|:--------:|
| `PS_INFRA_NETWORK_ID`         | Ps infra network id             | prestashop_localinfra_localinfra-network                                                       |    NO    |
| `PS_INFRA_MOUNT_SOURCE_PATH`  | Ps infra host mount source path | /var/www/html                                                                                  |    NO    |
| `PS_INFRA_MOUNT_TARGET_PATH`  | Ps infra container mount target | /var/www                                                                                       |    NO    |
| `PS_TEMPLATES_IMAGES_PREFIX`  | Ps infra images template prefix | prestashop_localinfra_template                                                                 |    NO    |
| `PS_ENTRY_POINT_SCRIPT_URL`   | Ps infra entry point script     | [See here](https://raw.githubusercontent.com/PrestaInfra/ps-auto-install-script/main/setup.sh) |    NO    |

NOTE : `PS_ENTRY_POINT_SCRIPT_URL` must be a shell script.
