export type * from './auth';

export type Hero = {
    id: number;
    name: string;
    created_at: string;
    updated_at: string;
};

export type Ticket = {
    id: number;
    hero_id: number;
    ticket_id: string;
    title: string;
    difficulty: number;
    status: 'todo' | 'in_progress' | 'done';
    hero?: Hero;
    created_at: string;
    updated_at: string;
};

export type LeaderboardEntry = {
    hero_id: number;
    hero_name: string;
    total_xp: number;
    completed_tickets: number;
};

export type DifficultyOption = {
    value: number;
    label: string;
    xp: number;
};

export type BoardColumns = {
    todo: Ticket[];
    in_progress: Ticket[];
    done: Ticket[];
};
