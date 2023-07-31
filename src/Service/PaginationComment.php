<?php

namespace App\Service;

use App\Repository\CommentRepository;

class PaginationComment
{
    private array $pagination;

    public function __construct(
        private readonly CommentRepository $commentRepository,
    )
    {
    }

    public function create($request, $topics): void
    {
        $offset = max(0, $request->query->getInt('offset',0));
        $paginator = $this->commentRepository->getCommentPaginator($topics,$offset);
        $this->pagination = [
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE)
        ];
    }

    /**
     * @return array
     */
    public function getPagination(): array
    {
        return $this->pagination;
    }

}