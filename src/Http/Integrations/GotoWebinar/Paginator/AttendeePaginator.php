<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Paginator;

use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\CursorPaginator;

class AttendeePaginator extends CursorPaginator
{
    public function __construct(
        protected Connector $connector,
        protected Request $request,
        protected ?int $perPageLimit = 200,
    ) {
        parent::__construct(connector: $connector, request: $request);
    }

    protected function getTotalPages(Response $response): int
    {
        return $response->json('page.totalPages') - 1;
    }

    protected function getNextCursor(Response $response): int|string
    {
        return $response->json('page.number') + 1;
    }

    protected function isLastPage(Response $response): bool
    {
        return $response->json('page.totalPages') - 1 === $response->json('page.number');
    }

    protected function getPageItems(Response $response, Request $request): array
    {
        return $response->json('_embedded.attendeeParticipationResponses');
    }

    protected function applyPagination(Request $request): Request
    {
        if ($this->currentResponse instanceof Response) {
            $request->query()->add('page', $this->getNextCursor($this->currentResponse));
        }

        if (isset($this->perPageLimit)) {
            $request->query()->add('size', $this->perPageLimit);
        }

        return $request;
    }
}
