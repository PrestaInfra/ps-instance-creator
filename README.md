# ps-instance-creator
Prestashop docker instance creator

![image](https://user-images.githubusercontent.com/16455155/201451513-05668acb-d987-46e1-bbba-0cc072298aca.png)

# Requirements :

- yarn >= 1.22.19
- php >= 8.1
- docker

# Install

- git clone https://github.com/PrestaInfra/ps-instance-creator.git
- cd ps-instance-creator
- composer install
- yarn install
- php -S localhost:9999


NOTE : Use releases for production version. See here https://github.com/PrestaInfra/ps-instance-creator/releases

# Env vars

| Var                            | description                     | Required |
|:-------------------------------|:--------------------------------|:--------:|
| `PS_INFRA_NETWORK_ID`          | Ps infra network id             |    NO    |
| `PS_INFRA_MOUNT_SOURCE_PATH`   | Ps infra host mount source path |    NO    |
| `PS_INFRA_MOUNT_TARGET_PATH`   | Ps infra container mount target |    NO    |