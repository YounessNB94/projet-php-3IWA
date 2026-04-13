<?php

declare(strict_types=1);

class AuthController
{
	private User $userModel;
	private Role $roleModel;

	public function __construct(?User $userModel = null, ?Role $roleModel = null)
	{
		$this->userModel = $userModel ?? new User();
		$this->roleModel = $roleModel ?? new Role();
	}

	public function showLogin(array $errors = [], array $old = []): void
	{
		require __DIR__ . '/../views/auth/login.php';
	}

	public function showRegister(array $errors = [], array $old = []): void
	{
		require __DIR__ . '/../views/auth/register.php';
	}

	public function register(): void
	{
		$this->ensureSession();

		$name = trim($_POST['name'] ?? '');
		$email = trim($_POST['email'] ?? '');
		$password = (string)($_POST['password'] ?? '');
		$confirm = (string)($_POST['password_confirm'] ?? '');

		$errors = [];
		$old = ['name' => $name, 'email' => $email];

		if ($name === '') {
			$errors[] = 'Le nom est obligatoire.';
		}

		if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors[] = 'Email invalide.';
		}

		if (strlen($password) < 6) {
			$errors[] = 'Le mot de passe doit contenir au moins 6 caracteres.';
		}

		if ($password !== $confirm) {
			$errors[] = 'Les mots de passe ne correspondent pas.';
		}

		if ($email !== '' && $this->userModel->findByEmail($email)) {
			$errors[] = 'Cet email est deja utilise.';
		}

		$visitorRole = $this->roleModel->findByName('visitor');
		if (!$visitorRole) {
			$errors[] = 'Role par defaut introuvable.';
		}

		if (!empty($errors)) {
			$this->showRegister($errors, $old);
			return;
		}

		$hash = password_hash($password, PASSWORD_DEFAULT);
		$created = $this->userModel->create($name, $email, $hash, (int)$visitorRole['id']);

		if (!$created) {
			$this->showRegister(['Erreur lors de la creation du compte.'], $old);
			return;
		}

		header('Location: /login');
		exit;
	}

	public function login(): void
	{
		$this->ensureSession();

		$email = trim($_POST['email'] ?? '');
		$password = (string)($_POST['password'] ?? '');

		$errors = [];
		$old = ['email' => $email];

		if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors[] = 'Email invalide.';
		}

		if ($password === '') {
			$errors[] = 'Mot de passe obligatoire.';
		}

		$user = $email !== '' ? $this->userModel->findByEmail($email) : null;
		if (!$user || !password_verify($password, $user['password'])) {
			$errors[] = 'Identifiants invalides.';
		}

		if (!empty($errors)) {
			$this->showLogin($errors, $old);
			return;
		}

		session_regenerate_id(true);

		$role = $this->roleModel->findById((int)$user['role_id']);

		$_SESSION['user_id'] = (int)$user['id'];
		$_SESSION['user_name'] = $user['name'];
		$_SESSION['user_role'] = $role ? $role['name'] : null;

		header('Location: /');
		exit;
	}

	public function logout(): void
	{
		$this->ensureSession();

		$_SESSION = [];

		if (ini_get('session.use_cookies')) {
			$params = session_get_cookie_params();
			setcookie(
				session_name(),
				'',
				time() - 42000,
				$params['path'],
				$params['domain'],
				$params['secure'],
				$params['httponly']
			);
		}

		session_destroy();

		header('Location: /login');
		exit;
	}

	private function ensureSession(): void
	{
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}
	}
}
