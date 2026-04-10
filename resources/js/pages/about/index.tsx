import { Head } from '@inertiajs/react';
import {
    Accordion,
    AccordionContent,
    AccordionItem,
    AccordionTrigger,
} from '@/components/ui/accordion';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

type Section = {
    title: string;
    items: { label: string; description: string; badge?: string }[];
};

const sections: Section[] = [
    {
        title: 'Code Quality',
        items: [
            {
                label: 'Husky',
                badge: 'Pre-commit hooks',
                description:
                    'Git hooks run Pint, PHPStan, and Pest automatically before every commit, preventing broken or unformatted code from ever reaching the repository.',
            },
            {
                label: 'Laravel Pint',
                badge: 'Code formatter',
                description:
                    'Opinionated PHP code style formatter built on PHP-CS-Fixer. Runs with --dirty to only lint changed files, keeping commits fast.',
            },
            {
                label: 'Larastan / PHPStan',
                badge: 'Static analysis',
                description:
                    'PHPStan with Laravel-specific rules catches type errors, incorrect return types, and misuse of Eloquent before runtime. Configured at a strict level to enforce full generic type annotations.',
            },
            {
                label: 'Pest',
                badge: 'Testing',
                description:
                    'Expressive PHP testing framework. Feature and unit tests cover actions, controllers, and form requests. Factories and RefreshDatabase keep tests isolated and reproducible.',
            },
        ],
    },
    {
        title: 'Stack',
        items: [
            {
                label: 'Laravel 13',
                badge: 'Backend',
                description:
                    'Full-featured PHP framework providing routing, middleware, Eloquent ORM, artisan commands, and the overall application foundation.',
            },
            {
                label: 'Inertia.js v3 + React 19',
                badge: 'Frontend',
                description:
                    'Inertia bridges Laravel and React without a separate API layer. Pages are React components rendered server-side via Inertia::render(), with client-side navigation preserving SPA feel. v3 features used include optimistic updates with automatic rollback for the drag-and-drop board.',
            },
            {
                label: 'Shadcn UI',
                badge: 'UI components',
                description:
                    'Unstyled, accessible component primitives (Card, Badge, Table, etc.) copied directly into the project and styled with Tailwind CSS v4. No runtime dependency — components are fully owned and customisable.',
            },
            {
                label: 'Tailwind CSS v4',
                badge: 'Styling',
                description:
                    'Utility-first CSS framework. v4 uses a Vite plugin instead of a PostCSS config and supports the new @theme directive for design tokens.',
            },
            {
                label: 'Laravel Wayfinder',
                badge: 'Type-safe routing',
                description:
                    'Auto-generates TypeScript functions from Laravel controllers and named routes. Frontend code imports from @/actions/ and calls .url() or .patch() instead of hardcoding URL strings, catching route changes at compile time.',
            },
            {
                label: 'SQLite',
                badge: 'Database',
                description:
                    'Zero-configuration file-based database used for local development simplicity. No Docker or local database server required — the database lives in database/database.sqlite.',
            },
        ],
    },
    {
        title: 'Architecture',
        items: [
            {
                label: 'Action pattern',
                badge: 'Design choice',
                description:
                    'Business logic lives in single-responsibility action classes (e.g. GetBoardTickets, UpdateTicketStatus, AddCompletedTicket) rather than fat controllers or service classes. Controllers resolve and delegate to actions, keeping them thin and testable in isolation.',
            },
            {
                label: 'hero config + Inertia shared data',
                badge: 'Design choice',
                description:
                    'Application-wide constants (ticket statuses, difficulty labels and colours) live in config/hero.php. HandleInertiaRequests shares them as hero props on every page load, so the frontend never hardcodes these values. TypeScript types in global.d.ts keep the shared data fully typed.',
            },
            {
                label: 'Eloquent casts + PHP enums',
                badge: 'Design choice',
                description:
                    'Ticket status is cast to a TicketStatus backed enum and difficulty to a Difficulty int enum with an xp() method (value × 10). This moves business logic onto the model layer and prevents invalid states at the type level.',
            },
        ],
    },
    {
        title: 'Database Schema',
        items: [
            {
                label: 'heroes',
                badge: 'id, name',
                description:
                    'Represents a player character. A hero can own many tickets and appear on the leaderboard once they have completed tickets.',
            },
            {
                label: 'tickets',
                badge: 'id, hero_id, ticket_id, title, difficulty, status',
                description:
                    'A unit of work assigned to a hero. ticket_id is the human-readable identifier (e.g. TICK-00101). difficulty is an integer 1–5 mapped to the Difficulty enum. status is todo | in_progress | done.',
            },
            {
                label: 'completed_tickets',
                badge: 'id, ticket_id, hero_id, completed_at',
                description:
                    'Join table that records when a ticket reaches done status. XP on the leaderboard is calculated by summing difficulty × 10 across a hero\'s completed_tickets rows joined to tickets.',
            },
            {
                label: 'users',
                badge: 'id, name, email',
                description:
                    'Standard Laravel auth table. Separate from heroes — a user account is the login identity while a hero is the in-app character that owns tickets.',
            },
        ],
    },
];

export default function About() {
    return (
        <>
            <Head title="About" />

            <div className="mb-8">
                <h1 className="mb-2 text-2xl font-bold">About</h1>
                <p className="text-muted-foreground">
                    Architecture and design decisions behind Ticket Hero.
                </p>
            </div>

            <Accordion type="multiple" defaultValue={sections.map((s) => s.title)}>
                {sections.map((section) => (
                    <AccordionItem key={section.title} value={section.title}>
                        <AccordionTrigger className="text-lg font-semibold">
                            {section.title}
                        </AccordionTrigger>
                        <AccordionContent>
                            <div className="grid gap-4 p-2 sm:grid-cols-2">
                                {section.items.map((item) => (
                                    <Card key={item.label}>
                                        <CardHeader className="pb-2">
                                            <div className="flex items-center justify-between gap-2">
                                                <CardTitle className="text-sm font-semibold">
                                                    {item.label}
                                                </CardTitle>
                                                {item.badge && (
                                                    <Badge
                                                        variant="secondary"
                                                        className="shrink-0 text-xs"
                                                    >
                                                        {item.badge}
                                                    </Badge>
                                                )}
                                            </div>
                                        </CardHeader>
                                        <CardContent>
                                            <p className="text-sm text-muted-foreground">
                                                {item.description}
                                            </p>
                                        </CardContent>
                                    </Card>
                                ))}
                            </div>
                        </AccordionContent>
                    </AccordionItem>
                ))}
            </Accordion>
        </>
    );
}
