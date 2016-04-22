<?php

namespace AppBundle\Command;

use AppBundle\Entity\Person;
use AppBundle\Services\UserManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class AddAdminCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:admin:add')
            ->setDescription('Add admin')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $em = $this->getContainer()->get('doctrine')->getManager();
        $usernameQuestion = new Question('Enter admin username: ');
        $firstnameQuestion = new Question('Firstname: ');
        $lastnameQuestion = new Question('Lastname: ');
        $emailQuestion = new Question('Email: ');
        $passwordQuestion = new Question('Password: ');
        $repeatPasswordQuestion = new Question('Repeat password: ');
        $roleQuestion = new ChoiceQuestion(
            'Choose role (default is admin): ',
            array('admin', 'moderator'),
            0
        );
        $roleQuestion->setErrorMessage('Role %s is invalid.');
        $birthQuestion = new Question('Birthday: ');
        $birthQuestion->setValidator(function ($answer) {
            if (!preg_match('/\d+-\d+-\d+/', $answer)) {
                throw new \RuntimeException(
                    'Date format: 1990-12-31'
                );
            }
            return $answer;
        });
        $bankQuestion = new Question('Bank details: ');

        $username = $helper->ask($input, $output, $usernameQuestion);
        $firstname = $helper->ask($input, $output, $firstnameQuestion);
        $lastname = $helper->ask($input, $output, $lastnameQuestion);
        $email = $helper->ask($input, $output, $emailQuestion);
        $password = $helper->ask($input, $output, $passwordQuestion);
        $repeatPassword = $helper->ask($input, $output, $repeatPasswordQuestion);
        if ($password != $repeatPassword) {
            die('Different passwords!' . "\n");
        }
        $role = $helper->ask($input, $output, $roleQuestion);
        $birth = $helper->ask($input, $output, $birthQuestion);
        $bank = $helper->ask($input, $output, $bankQuestion);

        if (
            $em->getRepository("AppBundle:Person")->findOneBy(["username" => $username]) ||
            $em->getRepository("AppBundle:Person")->findOneBy(["email" => $email])
        ) {
            die('User with those login or email already exists!' . "\n");
        } else {
            $encoder = $this->getContainer()->get('security.password_encoder');;
            $admin = new Person();
            $admin->setUsername($username);
            $admin->setFirstname($firstname);
            $admin->setLastname($lastname);
            $admin->setEmail($email);
            $admin->setAvatarFileName(UserManager::STANDARTAVATAR);

            $encoded = $encoder->encodePassword($admin, $password);
            $admin->setPassword($encoded);

            if ($role == 'admin') {
                $admin->setRole('ROLE_ADMIN');
            } elseif ($role == 'moderator') {
                $admin->setRole('ROLE_MODERATOR');
            }
            $admin->setIsActive(true);
            $admin->setBirthday($birth);
            $admin->setBankDetails($bank);

            $em->persist($admin);
            $em->flush();
            $output->writeln(
                'User '.$admin->getUsername(). ' with role '.$admin->getRole().' is created!'
            );
        }
    }
}