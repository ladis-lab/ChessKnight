<?php

namespace App\Services;

class ChessService
{
    // define possible moves for knight
    private array $knightMoves = [
        [-2, -1], [-2, 1], [2, -1], [2, 1],
        [-1, -2], [-1, 2], [1, -2], [1, 2]
    ];

    /**
     * Computes the shortest path (kinda self-explanatory)
     * @param array $start
     * @param array $end
     * @return array|array[]
     */
    public function getShortestPath(array $start, array $end): array
    {
        if ($start === $end) {
            return [$start];
        }

        $queue = new \SplQueue();
        $queue->enqueue([$start]);
        $used = [];

        while (!$queue->isEmpty()) {
            $path = $queue->dequeue();
            $current = end($path);
            $key = "{$current[0]},{$current[1]}";

            if (isset($used[$key])) {
                continue;
            }
            $used[$key] = true;

            // see all possible moes
            foreach ($this->knightMoves as [$dx, $dy]) {
                $nx = $current[0] + $dx;
                $ny = $current[1] + $dy;

                // move needs to be in chebsboard
                if ($this->isValidMove($nx, $ny)) {
                    //new path and check end
                    $next = [$nx, $ny];
                    $newPath = array_merge($path, [$next]);

                    if ($next === $end) {
                        return $newPath;
                    }

                    $queue->enqueue($newPath);
                }
            }
        }

        return [];
    }

    // is move in chssboord
    private function isValidMove(int $x, int $y): bool
    {
        return $x >= 0 && $x < 8 && $y >= 0 && $y < 8;
    }
}
