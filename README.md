# Test HelloCSE API

## Installation du projet
Ouvrir une console CMD et copier les lignes suivantes.
### Installer WSL :
```
wsl --install -d Ubuntu
```
Il sera demandé un nom d'utilisateur et un mot de passe.

### Cloner le projet :
```
cd ~
git clone https://github.com/Borohm/test-hello-cse.git
cd test-hello-cse
```

### Installer Docker :
```
# Add Docker's official GPG key:
sudo apt update
sudo apt install ca-certificates curl
sudo install -m 0755 -d /etc/apt/keyrings
sudo curl -fsSL https://download.docker.com/linux/ubuntu/gpg -o /etc/apt/keyrings/docker.asc
sudo chmod a+r /etc/apt/keyrings/docker.asc

# Add the repository to Apt sources:
sudo tee /etc/apt/sources.list.d/docker.sources <<EOF
Types: deb
URIs: https://download.docker.com/linux/ubuntu
Suites: $(. /etc/os-release && echo "${UBUNTU_CODENAME:-$VERSION_CODENAME}")
Components: stable
Architectures: $(dpkg --print-architecture)
Signed-By: /etc/apt/keyrings/docker.asc
EOF

sudo apt update
sudo apt install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
```

### Ajouter permissions Docker :
```
sudo groupadd docker
sudo usermod -aG docker $USER
sudo apt install util-linux-extra
newgrp docker
```

### Installer Make :
```
sudo apt update
sudo apt install make
```

### Installer le projet :
```
make install
```

## Utilisation de l'API
### Documentation Swagger :
Pour tester l'API, une documentation Swagger est disponible sur l'url suivante : http://localhost/api/documentation

### Tests unitaires :
Pour vérifier les tests unitaires, lancer la commande suivante:
```
make test
```