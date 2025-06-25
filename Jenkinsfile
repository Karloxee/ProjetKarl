pipeline {
    agent any

    environment {
        DOCKER_IMAGE = 'karloxe/devopscar'
        DOCKER_CREDENTIALS = 'docker-hub-credentials'
    }

    stages {
        stage('Cloner le code') {
            steps {
                git branch: 'master', url: 'https://github.com/Karloxee/ProjetKarl.git'
            }
        }

        stage('Tests PHPUnit') {
            steps {
                sh '''
                    echo "🔎 Vérification de PHPUnit..."
                    if command -v phpunit >/dev/null 2>&1; then
                        echo "✅ PHPUnit détecté — lancement des tests"
                        mkdir -p build/logs
                        phpunit --colors=always \
                                --display-deprecations \
                                --do-not-fail-on-deprecation \
                                --log-junit build/logs/junit.xml \
                                -c phpunit.xml
                    else
                        echo "PHPUnit non trouvé. Veuillez l’installer globalement ou via Composer."
                        exit 1
                    fi
                '''
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
    }
}
