import { Badge } from '@/components/ui/badge';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import type { LeaderboardEntry } from '@/types';
import { Head } from '@inertiajs/react';

type Props = {
    leaderboard: LeaderboardEntry[];
};

export default function Leaderboard({ leaderboard }: Props) {
    return (
        <>
            <Head title="Leaderboard" />

            <h1 className="mb-6 text-2xl font-bold">Leaderboard</h1>

            {leaderboard.length === 0 ? (
                <p className="text-muted-foreground">
                    No completed tickets yet. Complete some quests to see the
                    leaderboard!
                </p>
            ) : (
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead className="w-16">#</TableHead>
                            <TableHead>Hero</TableHead>
                            <TableHead className="text-center">
                                Completed Tickets
                            </TableHead>
                            <TableHead className="text-right">
                                Total XP
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        {leaderboard.map((entry, index) => (
                            <TableRow key={entry.hero_id}>
                                <TableCell className="font-medium">
                                    {index + 1}
                                </TableCell>
                                <TableCell className="font-medium">
                                    {entry.hero_name}
                                </TableCell>
                                <TableCell className="text-center">
                                    {entry.completed_tickets}
                                </TableCell>
                                <TableCell className="text-right">
                                    <Badge variant="secondary">
                                        {entry.total_xp} XP
                                    </Badge>
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            )}
        </>
    );
}
