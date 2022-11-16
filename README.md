# ps-instance-creator
Prestashop docker instance creator

![image](https://user-images.githubusercontent.com/16455155/202068606-eb9e4c4f-b069-4768-8e3a-23655b69a94d.png)

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
