import { Head, router, usePage } from '@inertiajs/react';
import { useState } from 'react';
import UpdateStatusController from '@/actions/App/Http/Controllers/Board/UpdateStatusController';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import type { BoardColumns, Ticket } from '@/types';

type Props = {
    columns: BoardColumns;
};

function TicketCard({ ticket, onDragStart }: { ticket: Ticket; onDragStart: (e: DragEvent, ticket: Ticket) => void }) {
    const { hero } = usePage().props;

    return (
        <Card
            draggable
            onDragStart={(e) => onDragStart(e as unknown as DragEvent, ticket)}
            className="cursor-grab active:cursor-grabbing active:opacity-50"
        >
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
            <CardContent>
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
            </CardContent>
        </Card>
    );
}

export default function Board({ columns }: Props) {
    const { hero } = usePage().props;
    const [dragOverColumn, setDragOverColumn] = useState<string | null>(null);

    const columnOrder: (keyof BoardColumns)[] = ['todo', 'in_progress', 'done'];

    function handleDragStart(e: DragEvent, ticket: Ticket) {
        e.dataTransfer!.setData('ticketId', String(ticket.id));
        e.dataTransfer!.setData('fromStatus', ticket.status);
        e.dataTransfer!.effectAllowed = 'move';
    }

    function handleDragOver(e: DragEvent, status: string) {
        e.preventDefault();
        e.dataTransfer!.dropEffect = 'move';
        setDragOverColumn(status);
    }

    function handleDragLeave() {
        setDragOverColumn(null);
    }

    function handleDrop(e: DragEvent, toStatus: keyof BoardColumns) {
        e.preventDefault();
        setDragOverColumn(null);

        const ticketId = Number(e.dataTransfer!.getData('ticketId'));
        const fromStatus = e.dataTransfer!.getData('fromStatus') as keyof BoardColumns;

        if (fromStatus === toStatus) return;

        const ticket = columns[fromStatus].find((t) => t.id === ticketId);
        if (!ticket) return;

        router.optimistic((props) => {
            const currentColumns = props.columns as BoardColumns;
            return {
                columns: {
                    ...currentColumns,
                    [fromStatus]: currentColumns[fromStatus].filter((t) => t.id !== ticketId),
                    [toStatus]: [...currentColumns[toStatus], { ...ticket, status: toStatus }],
                },
            };
        }).patch(
            UpdateStatusController.url({ ticket: ticketId }),
            { status: toStatus },
            { preserveScroll: true },
        );
    }

    return (
        <>
            <Head title="Board" />

            <h1 className="mb-6 text-2xl font-bold">Board</h1>

            <div className="grid grid-cols-1 gap-6 md:grid-cols-3">
                {columnOrder.map((status) => (
                    <div
                        key={status}
                        onDragOver={(e) => handleDragOver(e as unknown as DragEvent, status)}
                        onDragLeave={handleDragLeave}
                        onDrop={(e) => handleDrop(e as unknown as DragEvent, status)}
                        className="flex flex-col"
                    >
                        <div className="mb-3 flex items-center justify-between">
                            <h2 className="text-sm font-semibold uppercase tracking-wide text-muted-foreground">
                                {hero.statuses[status]}
                            </h2>
                            <Badge variant="secondary">
                                {columns[status].length}
                            </Badge>
                        </div>
                        <div
                            className={`min-h-24 space-y-3 rounded-lg p-1 transition-colors ${dragOverColumn === status ? 'border-2 border-dashed border-primary/50 bg-muted/50' : 'border-2 border-transparent'}`}
                        >
                            {columns[status].length === 0 ? (
                                <p className="rounded-lg border border-dashed p-4 text-center text-sm text-muted-foreground">
                                    No tickets
                                </p>
                            ) : (
                                columns[status].map((ticket) => (
                                    <TicketCard
                                        key={ticket.id}
                                        ticket={ticket}
                                        onDragStart={handleDragStart}
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
