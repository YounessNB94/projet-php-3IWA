<?php

declare(strict_types=1);

class PageController
{
	private Page $pageModel;

	public function __construct(?Page $pageModel = null)
	{
		$this->pageModel = $pageModel ?? new Page();
	}

	public function index(): void
	{
		$pages = $this->pageModel->all();
		require __DIR__ . '/../views/pages/index.php';
	}

	public function create(): void
	{
		$errors = [];
		$old = [];
		require __DIR__ . '/../views/pages/create.php';
	}

	public function store(): void
	{
		$title = trim($_POST['title'] ?? '');
		$content = trim($_POST['content'] ?? '');
		$status = $_POST['status'] ?? 'draft';

		$errors = [];
		$old = ['title' => $title, 'content' => $content, 'status' => $status];

		if ($title === '') {
			$errors[] = 'Le titre est obligatoire.';
		}

		if ($content === '') {
			$errors[] = 'Le contenu est obligatoire.';
		}

		if (!in_array($status, ['published', 'draft'], true)) {
			$errors[] = 'Statut invalide.';
		}

		$authorId = (int)($_SESSION['user_id'] ?? 0);
		if ($authorId <= 0) {
			$errors[] = 'Auteur invalide.';
		}

		if (!empty($errors)) {
			require __DIR__ . '/../views/pages/create.php';
			return;
		}

		$created = $this->pageModel->create($title, $content, $status, $authorId);
		if (!$created) {
			$errors[] = 'Erreur lors de la creation.';
			require __DIR__ . '/../views/pages/create.php';
			return;
		}

		header('Location: /pages');
		exit;
	}

	public function edit(int $id): void
	{
		$page = $this->pageModel->findById($id);
		if (!$page) {
			http_response_code(404);
			echo 'Page introuvable.';
			return;
		}

		$errors = [];
		require __DIR__ . '/../views/pages/edit.php';
	}

	public function update(int $id): void
	{
		$page = $this->pageModel->findById($id);
		if (!$page) {
			http_response_code(404);
			echo 'Page introuvable.';
			return;
		}

		$title = trim($_POST['title'] ?? '');
		$content = trim($_POST['content'] ?? '');
		$status = $_POST['status'] ?? 'draft';

		$errors = [];
		$page['title'] = $title;
		$page['content'] = $content;
		$page['status'] = $status;

		if ($title === '') {
			$errors[] = 'Le titre est obligatoire.';
		}

		if ($content === '') {
			$errors[] = 'Le contenu est obligatoire.';
		}

		if (!in_array($status, ['published', 'draft'], true)) {
			$errors[] = 'Statut invalide.';
		}

		if (!empty($errors)) {
			require __DIR__ . '/../views/pages/edit.php';
			return;
		}

		$updated = $this->pageModel->update($id, $title, $content, $status);
		if (!$updated) {
			$errors[] = 'Erreur lors de la mise a jour.';
			require __DIR__ . '/../views/pages/edit.php';
			return;
		}

		header('Location: /pages');
		exit;
	}

	public function delete(int $id): void
	{
		$this->pageModel->delete($id);
		header('Location: /pages');
		exit;
	}

	public function showBySlug(string $slug): void
	{
		$page = $this->pageModel->findBySlug($slug);
		if (!$page || $page['status'] !== 'published') {
			http_response_code(404);
			echo 'Page introuvable.';
			return;
		}

		require __DIR__ . '/../views/front/page.php';
	}
}
