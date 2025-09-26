// User and Authentication Types
export interface User {
  id: string;
  name: string;
  email: string;
  avatar?: string;
  role: UserRole;
  companyId: string;
  branchId?: string;
  permissions: Permission[];
  isActive: boolean;
  createdAt: Date;
  updatedAt: Date;
}

export type UserRole = 'admin' | 'manager' | 'employee' | 'viewer';

export interface Permission {
  id: string;
  name: string;
  description: string;
  resource: string;
  action: string;
}

// Customer Types
export interface Customer {
  id: string;
  name: string;
  email?: string;
  phone?: string;
  company?: string;
  status: CustomerStatus;
  tags: string[];
  notes: string;
  createdAt: Date;
  updatedAt: Date;
  lastContactDate?: Date;
  assignedTo?: string;
  customFields: Record<string, any>;
}

export type CustomerStatus = 'active' | 'inactive' | 'potential' | 'churned';

// Company and Branch Types
export interface Company {
  id: string;
  name: string;
  logo?: string;
  industry?: string;
  website?: string;
  address: Address;
  settings: CompanySettings;
  subscription: Subscription;
  createdAt: Date;
  updatedAt: Date;
}

export interface Branch {
  id: string;
  companyId: string;
  name: string;
  address: Address;
  phone?: string;
  email?: string;
  managerId?: string;
  isActive: boolean;
  createdAt: Date;
  updatedAt: Date;
}

export interface Address {
  street: string;
  city: string;
  state: string;
  country: string;
  postalCode: string;
}

// Messaging Types
export interface Message {
  id: string;
  senderId: string;
  recipientId: string;
  recipientType: 'customer' | 'user' | 'group';
  content: MessageContent;
  channel: MessageChannel;
  status: MessageStatus;
  scheduledAt?: Date;
  sentAt?: Date;
  readAt?: Date;
  createdAt: Date;
}

export interface MessageContent {
  text?: string;
  html?: string;
  attachments?: Attachment[];
  templateId?: string;
  variables?: Record<string, string>;
}

export type MessageChannel = 'email' | 'sms' | 'whatsapp' | 'telegram' | 'push';
export type MessageStatus = 'draft' | 'scheduled' | 'sent' | 'delivered' | 'read' | 'failed';

export interface Attachment {
  id: string;
  name: string;
  url: string;
  type: string;
  size: number;
}

// Analytics and Reports Types
export interface AnalyticsData {
  period: DateRange;
  metrics: Metric[];
  charts: ChartData[];
}

export interface Metric {
  id: string;
  name: string;
  value: number;
  previousValue?: number;
  change?: number;
  changeType: 'increase' | 'decrease' | 'neutral';
  format: 'number' | 'percentage' | 'currency';
}

export interface ChartData {
  id: string;
  title: string;
  type: ChartType;
  data: any[];
  config?: any;
}

export type ChartType = 'line' | 'bar' | 'pie' | 'doughnut' | 'area';

export interface DateRange {
  startDate: Date;
  endDate: Date;
}

// Settings Types
export interface CompanySettings {
  language: string;
  timezone: string;
  currency: string;
  dateFormat: string;
  theme: ThemeSettings;
  features: FeatureSettings;
  integrations: IntegrationSettings;
}

export interface ThemeSettings {
  primaryColor: string;
  logo?: string;
  customCss?: string;
}

export interface FeatureSettings {
  aiSuggestions: boolean;
  smartNotifications: boolean;
  multiFactorAuth: boolean;
  realTimeSync: boolean;
  autoBackup: boolean;
}

export interface IntegrationSettings {
  email: EmailIntegration;
  sms: SMSIntegration;
  crm: CRMIntegration[];
  ecommerce: EcommerceIntegration[];
}

export interface EmailIntegration {
  provider: string;
  config: Record<string, any>;
  isActive: boolean;
}

export interface SMSIntegration {
  provider: string;
  config: Record<string, any>;
  isActive: boolean;
}

export interface CRMIntegration {
  id: string;
  name: string;
  type: string;
  config: Record<string, any>;
  isActive: boolean;
}

export interface EcommerceIntegration {
  id: string;
  name: string;
  platform: string;
  config: Record<string, any>;
  isActive: boolean;
}

// Subscription Types
export interface Subscription {
  id: string;
  plan: SubscriptionPlan;
  status: SubscriptionStatus;
  startDate: Date;
  endDate?: Date;
  features: string[];
  limits: SubscriptionLimits;
}

export type SubscriptionPlan = 'basic' | 'professional' | 'enterprise';
export type SubscriptionStatus = 'active' | 'inactive' | 'cancelled' | 'expired';

export interface SubscriptionLimits {
  users: number;
  customers: number;
  messages: number;
  storage: number; // in GB
}

// Notification Types
export interface Notification {
  id: string;
  userId: string;
  title: string;
  message: string;
  type: NotificationType;
  priority: NotificationPriority;
  isRead: boolean;
  actionUrl?: string;
  createdAt: Date;
}

export type NotificationType = 'info' | 'success' | 'warning' | 'error' | 'system';
export type NotificationPriority = 'low' | 'medium' | 'high' | 'urgent';

// API Response Types
export interface ApiResponse<T> {
  data: T;
  message: string;
  success: boolean;
}

export interface PaginatedResponse<T> {
  data: T[];
  pagination: {
    page: number;
    pageSize: number;
    total: number;
    totalPages: number;
  };
}

// Form Types
export interface LoginForm {
  email: string;
  password: string;
  rememberMe: boolean;
}

export interface CustomerForm {
  name: string;
  email?: string;
  phone?: string;
  company?: string;
  status: CustomerStatus;
  tags: string[];
  notes: string;
  customFields: Record<string, any>;
}

// Navigation Types
export interface NavItem {
  id: string;
  label: string;
  icon: string;
  path: string;
  children?: NavItem[];
  requiredPermissions?: string[];
}