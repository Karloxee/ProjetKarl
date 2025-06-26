pipeline {
    agent any

    environment {
        DOCKER_IMAGE = 'karloxe/devopscar'
        DOCKER_CREDENTIALS = 'docker-hub-credentials'
        CONTAINER_PHP = 'web1' 
    }

    stages {
        stage('Cloner le code') {
            steps {
                git branch: 'master', url: 'https://github.com/Karloxee/ProjetKarl.git'
            }
        }

        stage('Construire l’image Docker') {
            steps {
                script {
                    sh "docker build -t $DOCKER_IMAGE:$BUILD_NUMBER ."
                }
            }
        }

        stage('Pousser sur Docker Hub') {
            steps {
                script {
                    withDockerRegistry([credentialsId: "$DOCKER_CREDENTIALS", url: ""]) {
                        sh "docker push $DOCKER_IMAGE:${BUILD_NUMBER}"
                    }
                }
            }
        }

        stage('Déployer avec Docker Compose') {
            steps {
                script {
                    sh "export BUILD_NUMBER=${BUILD_NUMBER} && docker-compose down"
                    sh "export BUILD_NUMBER=${BUILD_NUMBER} && docker-compose up -d"
                }
            }
        }

        stage('Tester la connexion PHP → MariaDB') {
            steps {
                script {
                    sh """
                        echo 'Vérification de la connexion PHP → MariaDB...'
                        docker exec $CONTAINER_PHP curl -s http://localhost/test_db.php | tee result.log
                        
                        if ! grep -q 'Connexion réussie' result.log; then
                            echo 'La connexion à MariaDB a échoué.'
                            exit 1
                        else
                            echo 'Connexion validée entre PHP et MariaDB.'
                        fi
                    """
                }
            }
        }
    }
}
