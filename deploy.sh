chmod 400 $AWS_VM_PEM
ssh -o "StrictHostKeyChecking=no" -i $AWS_VM_PEM $AWS_VM_user@$AWS_VM_ip "rm -rf engima && mkdir engima"
scp -o "StrictHostKeyChecking=no" -i $AWS_VM_PEM -r app $AWS_VM_user@$AWS_VM_ip:~/engima
scp -o "StrictHostKeyChecking=no" -i $AWS_VM_PEM -r public $AWS_VM_user@$AWS_VM_ip:~/engima
