import { Head, router, usePage } from '@inertiajs/react';
import UpdateStatusController from '@/actions/App/Http/Controllers/Board/UpdateStatusController';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import type { BoardColumns, Ticket } from '@/types';

type Props = {
    columns: BoardColumns;
};

function TicketCard({ ticket }: { ticket: Ticket }) {
    const { hero } = usePage().props;
    function handleStatusChange(newStatus: string | null) {
        if (!newStatus) {
            return;
        }

        router.patch(
            UpdateStatusController.url({ ticket: ticket.id }),
            { status: newStatus },
            { preserveScroll: true },
        );
    }

    return (
        <Card>
            <CardHeader className="pb-2">
                <div className="flex items-start justify-between gap-2">
                    <CardTitle className="text-sm font-medium">
                        {ticket.title}
                    </CardTitle>
                    <span className="shrink-0 text-xs text-muted-foreground">
                        {ticket.ticket_id}
                    </span>
                </div>
            </CardHeader>
            <CardContent className="space-y-3">
                <div className="flex items-center gap-2">
                    {ticket.hero && (
                        <Badge variant="outline">{ticket.hero.name}</Badge>
                    )}
                    <span
                        className={`inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium ${hero.difficulties[ticket.difficulty]?.color ?? ''}`}
                    >
                        {hero.difficulties[ticket.difficulty]?.label} (
                        {ticket.difficulty * 10} XP)
                    </span>
                </div>
                <Select
                    value={ticket.status}
                    onValueChange={handleStatusChange}
                >
                    <SelectTrigger className="h-8 text-xs">
                        <SelectValue />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem value="todo">To Do</SelectItem>
                        <SelectItem value="in_progress">
                            In Progress
                        </SelectItem>
                        <SelectItem value="done">Done</SelectItem>
                    </SelectContent>
                </Select>
            </CardContent>
        </Card>
    );
}

export default function Board({ columns }: Props) {
    const { hero } = usePage().props;
    const columnOrder: (keyof BoardColumns)[] = [
        'todo',
        'in_progress',
        'done',
    ];

    return (
        <>
            <Head title="Board" />

            <h1 className="mb-6 text-2xl font-bold">Board</h1>

            <div className="grid grid-cols-1 gap-6 md:grid-cols-3">
                {columnOrder.map((status) => (
                    <div key={status}>
                        <div className="mb-3 flex items-center justify-between">
                            <h2 className="text-sm font-semibold uppercase tracking-wide text-muted-foreground">
                                {hero.statuses[status]}
                            </h2>
                            <Badge variant="secondary">
                                {columns[status].length}
                            </Badge>
                        </div>
                        <div className="space-y-3">
                            {columns[status].length === 0 ? (
                                <p className="rounded-lg border border-dashed p-4 text-center text-sm text-muted-foreground">
                                    No tickets
                                </p>
                            ) : (
                                columns[status].map((ticket) => (
                                    <TicketCard
                                        key={ticket.id}
                                        ticket={ticket}
                                    />
                                ))
                            )}
                        </div>
                    </div>
                ))}
            </div>
        </>
    );
}
