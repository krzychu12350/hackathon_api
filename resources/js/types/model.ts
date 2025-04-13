export type File = {
    id: number;
    url: string;
    type: FileType;
    extension?: FileExtension;
    created_at?: string;
    updated_at?: string;
    plant?: Plant;
};
export type LinkedSocialAccount = {
    id: number;
    provider_id: string;
    provider_name: string;
    user_id: number;
    created_at?: string;
    updated_at?: string;
    user?: User;
};
export type Plant = {
    id: number;
    name: string;
    description?: string;
    expected_humidity: number;
    current_humidity: number;
    user_id: number;
    file_id?: number;
    created_at?: string;
    updated_at?: string;
    user?: User;
    photo?: File;
};
export type PlantCategory = {
    id: number;
    name: string;
    created_at?: string;
    updated_at?: string;
    plants?: Plant[];
};
export type User = {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
    role: UserRole;
    created_at?: string;
    updated_at?: string;
    linked_social_accounts?: LinkedSocialAccount[];
    plants?: Plant[];
};
export enum FileExtension {
    JPG = "jpg",
    JPEG = "jpeg",
    PNG = "png",
    PDF = "pdf",
    DOC = "doc",
    DOCX = "docx",
    MP3 = "mp3",
    MP4 = "mp4",
    WAV = "wav",
    OGG = "ogg",
    TXT = "txt",
    CSV = "csv",
    OTHER = "other"
}
export enum FileType {
    IMAGE = "image",
    AUDIO = "audio",
    VIDEO = "video",
    DOCUMENT = "document",
    OTHER = "other"
}
export enum PlantWaterAmount {
    SMALL = 0,
    NORMAL = 1,
    LARGE = 2
}
export enum UserRole {
    USER = "user",
    ADMIN = "admin"
}
