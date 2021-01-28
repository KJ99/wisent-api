<?php


namespace App\Command;


use App\Service\UserService;
use App\ViewModel\RequestViewModel\UserRequestViewModel;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:user:create';

    private SerializerInterface $serializer;
    private UserService $userService;

    public function __construct(UserService $userService, SerializerInterface $serializer, string $name = null)
    {
        $this->serializer = $serializer;
        $this->userService = $userService;
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $emailQuestion = new Question('Email: ');
        $usernameQuestion = new Question('Username: ');
        $passwordQuestion = new Question('Password: ');
        $passwordQuestion
            ->setHiddenFallback(true)
            ->setHidden(true);
        $confirmPasswordQuestion = new Question('Confirm password: ');
        $confirmPasswordQuestion
            ->setHiddenFallback(true)
            ->setHidden(true);
        $rolesQuestion = new ChoiceQuestion('Uprawnienia: ',
            ['user', 'moderator', 'admin'], 0
        );


        $helper = $this->getHelper('question');

        $data = [
            'email' => $helper->ask($input, $output, $emailQuestion),
            'username' => $helper->ask($input, $output, $usernameQuestion),
            'password' => $helper->ask($input, $output, $passwordQuestion),
            'confirm_password' => $helper->ask($input, $output, $confirmPasswordQuestion),
            'roles' => $this->userService->getUserRoles($helper->ask($input, $output, $rolesQuestion))
        ];
        $dataJson = json_encode($data);
        $model = $this->serializer->deserialize($dataJson, UserRequestViewModel::class, 'json');
        $result = $this->userService->createUser($model);
        $output->writeln($this->serializer->serialize($result->getViewModel(), 'json'));
        return $result->getHttpCode() == 201 ? Command::SUCCESS : Command::FAILURE;
    }


}