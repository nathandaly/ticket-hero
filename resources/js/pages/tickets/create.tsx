import StoreWebController from '@/actions/App/Http/Controllers/Tickets/StoreWebController';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import type { DifficultyOption, Hero } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import type { FormEvent } from 'react';

type Props = {
    heroes: Hero[];
    difficulties: DifficultyOption[];
};

export default function CreateTicket({ heroes, difficulties }: Props) {
    const form = useForm({
        title: '',
        ticketId: '',
        difficulty: '',
        heroId: '',
    });

    function handleSubmit(e: FormEvent) {
        e.preventDefault();
        form.submit(StoreWebController());
    }

    return (
        <>
            <Head title="Create Ticket" />

            <div className="mx-auto max-w-lg">
                <Card>
                    <CardHeader>
                        <CardTitle>Create Ticket</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form onSubmit={handleSubmit} className="space-y-4">
                            <div className="space-y-2">
                                <Label htmlFor="title">Title</Label>
                                <Input
                                    id="title"
                                    value={form.data.title}
                                    onChange={(e) =>
                                        form.setData('title', e.target.value)
                                    }
                                    placeholder="Fix login bug"
                                />
                                {form.errors.title && (
                                    <p className="text-sm text-destructive">
                                        {form.errors.title}
                                    </p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="ticketId">Ticket ID</Label>
                                <Input
                                    id="ticketId"
                                    value={form.data.ticketId}
                                    onChange={(e) =>
                                        form.setData('ticketId', e.target.value)
                                    }
                                    placeholder="JIRA-123"
                                />
                                {form.errors.ticketId && (
                                    <p className="text-sm text-destructive">
                                        {form.errors.ticketId}
                                    </p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label>Difficulty</Label>
                                <Select
                                    value={form.data.difficulty}
                                    onValueChange={(value) =>
                                        form.setData('difficulty', value ?? '')
                                    }
                                >
                                    <SelectTrigger>
                                        <SelectValue placeholder="Select difficulty" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {difficulties.map((d) => (
                                            <SelectItem
                                                key={d.value}
                                                value={String(d.value)}
                                            >
                                                {d.label} ({d.xp} XP)
                                            </SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                                {form.errors.difficulty && (
                                    <p className="text-sm text-destructive">
                                        {form.errors.difficulty}
                                    </p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label>Assign Hero</Label>
                                <Select
                                    value={form.data.heroId}
                                    onValueChange={(value) =>
                                        form.setData('heroId', value ?? '')
                                    }
                                >
                                    <SelectTrigger>
                                        <SelectValue placeholder="Select a hero" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {heroes.map((hero) => (
                                            <SelectItem
                                                key={hero.id}
                                                value={String(hero.id)}
                                            >
                                                {hero.name}
                                            </SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                                {form.errors.heroId && (
                                    <p className="text-sm text-destructive">
                                        {form.errors.heroId}
                                    </p>
                                )}
                            </div>

                            <Button
                                type="submit"
                                className="w-full"
                                disabled={form.processing}
                            >
                                {form.processing
                                    ? 'Creating...'
                                    : 'Create Ticket'}
                            </Button>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}
