import React from 'react';
import { Routes, Route, Navigate } from 'react-router-dom';
import { useAuth } from '../contexts/AuthContext';
import MainLayout from '../components/Layout/MainLayout';
import LoginPage from '../pages/Auth/LoginPage';
import DashboardPage from '../pages/Dashboard/DashboardPage';

// Placeholder components for other routes
const CustomersPage = () => (
  <div className="text-center py-12">
    <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-4">إدارة العملاء</h2>
    <p className="text-gray-600 dark:text-gray-400">صفحة إدارة العملاء قيد التطوير</p>
  </div>
);

const MessagesPage = () => (
  <div className="text-center py-12">
    <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-4">نظام الرسائل</h2>
    <p className="text-gray-600 dark:text-gray-400">صفحة نظام الرسائل قيد التطوير</p>
  </div>
);

const AnalyticsPage = () => (
  <div className="text-center py-12">
    <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-4">التقارير والإحصائيات</h2>
    <p className="text-gray-600 dark:text-gray-400">صفحة التقارير والإحصائيات قيد التطوير</p>
  </div>
);

const CompanyPage = () => (
  <div className="text-center py-12">
    <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-4">إدارة الشركة</h2>
    <p className="text-gray-600 dark:text-gray-400">صفحة إدارة الشركة قيد التطوير</p>
  </div>
);

const TeamPage = () => (
  <div className="text-center py-12">
    <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-4">إدارة الفريق</h2>
    <p className="text-gray-600 dark:text-gray-400">صفحة إدارة الفريق قيد التطوير</p>
  </div>
);

const AIPage = () => (
  <div className="text-center py-12">
    <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-4">الذكاء الاصطناعي</h2>
    <p className="text-gray-600 dark:text-gray-400">صفحة الذكاء الاصطناعي قيد التطوير</p>
  </div>
);

const NotificationsPage = () => (
  <div className="text-center py-12">
    <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-4">التنبيهات الذكية</h2>
    <p className="text-gray-600 dark:text-gray-400">صفحة التنبيهات الذكية قيد التطوير</p>
  </div>
);

const SecurityPage = () => (
  <div className="text-center py-12">
    <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-4">الأمان المتقدم</h2>
    <p className="text-gray-600 dark:text-gray-400">صفحة الأمان المتقدم قيد التطوير</p>
  </div>
);

const SettingsPage = () => (
  <div className="text-center py-12">
    <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-4">الإعدادات</h2>
    <p className="text-gray-600 dark:text-gray-400">صفحة الإعدادات قيد التطوير</p>
  </div>
);

// Protected Route Component
const ProtectedRoute: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const { isAuthenticated, loading } = useAuth();

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900">
        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600"></div>
      </div>
    );
  }

  if (!isAuthenticated) {
    return <Navigate to="/login" replace />;
  }

  return <MainLayout>{children}</MainLayout>;
};

const AppRoutes: React.FC = () => {
  return (
    <Routes>
      {/* Public Routes */}
      <Route path="/login" element={<LoginPage />} />
      
      {/* Protected Routes */}
      <Route
        path="/dashboard"
        element={
          <ProtectedRoute>
            <DashboardPage />
          </ProtectedRoute>
        }
      />
      <Route
        path="/customers"
        element={
          <ProtectedRoute>
            <CustomersPage />
          </ProtectedRoute>
        }
      />
      <Route
        path="/messages"
        element={
          <ProtectedRoute>
            <MessagesPage />
          </ProtectedRoute>
        }
      />
      <Route
        path="/analytics"
        element={
          <ProtectedRoute>
            <AnalyticsPage />
          </ProtectedRoute>
        }
      />
      <Route
        path="/company"
        element={
          <ProtectedRoute>
            <CompanyPage />
          </ProtectedRoute>
        }
      />
      <Route
        path="/team"
        element={
          <ProtectedRoute>
            <TeamPage />
          </ProtectedRoute>
        }
      />
      <Route
        path="/ai"
        element={
          <ProtectedRoute>
            <AIPage />
          </ProtectedRoute>
        }
      />
      <Route
        path="/notifications"
        element={
          <ProtectedRoute>
            <NotificationsPage />
          </ProtectedRoute>
        }
      />
      <Route
        path="/security"
        element={
          <ProtectedRoute>
            <SecurityPage />
          </ProtectedRoute>
        }
      />
      <Route
        path="/settings"
        element={
          <ProtectedRoute>
            <SettingsPage />
          </ProtectedRoute>
        }
      />
      
      {/* Default redirect */}
      <Route path="/" element={<Navigate to="/dashboard" replace />} />
      
      {/* Catch all route */}
      <Route path="*" element={<Navigate to="/dashboard" replace />} />
    </Routes>
  );
};

export default AppRoutes;