import React from 'react';
import {
  Users,
  MessageSquare,
  TrendingUp,
  DollarSign,
  Calendar,
  Activity,
  ArrowUp,
  ArrowDown,
  Plus
} from 'lucide-react';
import { useTheme } from '../../contexts/ThemeContext';

const DashboardPage: React.FC = () => {
  const { language } = useTheme();

  const metrics = [
    {
      id: 'customers',
      title: language === 'ar' ? 'إجمالي العملاء' : 'Total Customers',
      value: '1,234',
      change: '+12%',
      changeType: 'increase' as const,
      icon: Users,
      color: 'blue'
    },
    {
      id: 'messages',
      title: language === 'ar' ? 'الرسائل المرسلة' : 'Messages Sent',
      value: '5,678',
      change: '+8%',
      changeType: 'increase' as const,
      icon: MessageSquare,
      color: 'green'
    },
    {
      id: 'revenue',
      title: language === 'ar' ? 'الإيرادات الشهرية' : 'Monthly Revenue',
      value: '$12,345',
      change: '+23%',
      changeType: 'increase' as const,
      icon: DollarSign,
      color: 'purple'
    },
    {
      id: 'conversion',
      title: language === 'ar' ? 'معدل التحويل' : 'Conversion Rate',
      value: '3.2%',
      change: '-0.5%',
      changeType: 'decrease' as const,
      icon: TrendingUp,
      color: 'orange'
    }
  ];

  const recentActivities = [
    {
      id: 1,
      type: 'customer',
      message: language === 'ar' ? 'عميل جديد: أحمد محمد' : 'New customer: Ahmad Mohamed',
      time: language === 'ar' ? 'منذ 5 دقائق' : '5 minutes ago',
      color: 'blue'
    },
    {
      id: 2,
      type: 'message',
      message: language === 'ar' ? 'تم إرسال حملة تسويقية جديدة' : 'New marketing campaign sent',
      time: language === 'ar' ? 'منذ 15 دقيقة' : '15 minutes ago',
      color: 'green'
    },
    {
      id: 3,
      type: 'system',
      message: language === 'ar' ? 'تم تحديث النظام بنجاح' : 'System updated successfully',
      time: language === 'ar' ? 'منذ ساعة' : '1 hour ago',
      color: 'purple'
    }
  ];

  const upcomingTasks = [
    {
      id: 1,
      title: language === 'ar' ? 'اجتماع مع العميل الجديد' : 'Meeting with new client',
      time: language === 'ar' ? '2:00 م' : '2:00 PM',
      priority: 'high'
    },
    {
      id: 2,
      title: language === 'ar' ? 'مراجعة تقرير المبيعات' : 'Review sales report',
      time: language === 'ar' ? '4:30 م' : '4:30 PM',
      priority: 'medium'
    },
    {
      id: 3,
      title: language === 'ar' ? 'إرسال عروض الأسعار' : 'Send price quotes',
      time: language === 'ar' ? 'غداً 10:00 ص' : 'Tomorrow 10:00 AM',
      priority: 'low'
    }
  ];

  const getColorClasses = (color: string) => {
    switch (color) {
      case 'blue':
        return 'bg-blue-500 text-blue-500 bg-blue-50 dark:bg-blue-900/20';
      case 'green':
        return 'bg-green-500 text-green-500 bg-green-50 dark:bg-green-900/20';
      case 'purple':
        return 'bg-purple-500 text-purple-500 bg-purple-50 dark:bg-purple-900/20';
      case 'orange':
        return 'bg-orange-500 text-orange-500 bg-orange-50 dark:bg-orange-900/20';
      default:
        return 'bg-gray-500 text-gray-500 bg-gray-50 dark:bg-gray-900/20';
    }
  };

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-2xl font-bold text-gray-900 dark:text-white">
            {language === 'ar' ? 'لوحة التحكم' : 'Dashboard'}
          </h1>
          <p className="text-gray-600 dark:text-gray-400">
            {language === 'ar' ? 'نظرة شاملة على أداء نشاطك التجاري' : 'Comprehensive overview of your business performance'}
          </p>
        </div>
        <button className="flex items-center space-x-2 rtl:space-x-reverse bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition-colors">
          <Plus className="w-4 h-4" />
          <span>{language === 'ar' ? 'إضافة عميل جديد' : 'Add New Customer'}</span>
        </button>
      </div>

      {/* Metrics Cards */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {metrics.map((metric) => {
          const Icon = metric.icon;
          const colorClasses = getColorClasses(metric.color);
          const [, textColor, cardBg] = colorClasses.split(' ');
          
          return (
            <div key={metric.id} className="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
              <div className="flex items-center justify-between">
                <div className={`p-3 rounded-lg ${cardBg}`}>
                  <Icon className={`w-6 h-6 ${textColor}`} />
                </div>
                <div className={`flex items-center space-x-1 rtl:space-x-reverse text-sm ${
                  metric.changeType === 'increase' ? 'text-green-600' : 'text-red-600'
                }`}>
                  {metric.changeType === 'increase' ? (
                    <ArrowUp className="w-4 h-4" />
                  ) : (
                    <ArrowDown className="w-4 h-4" />
                  )}
                  <span>{metric.change}</span>
                </div>
              </div>
              <div className="mt-4">
                <h3 className="text-2xl font-bold text-gray-900 dark:text-white">
                  {metric.value}
                </h3>
                <p className="text-sm text-gray-600 dark:text-gray-400 mt-1">
                  {metric.title}
                </p>
              </div>
            </div>
          );
        })}
      </div>

      {/* Charts and Tables Row */}
      <div className="grid grid-cols-1 xl:grid-cols-3 gap-6">
        {/* Revenue Chart */}
        <div className="xl:col-span-2 bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
          <div className="flex items-center justify-between mb-6">
            <h3 className="text-lg font-semibold text-gray-900 dark:text-white">
              {language === 'ar' ? 'الإيرادات الشهرية' : 'Monthly Revenue'}
            </h3>
            <select className="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-1 text-sm">
              <option>{language === 'ar' ? 'آخر 6 أشهر' : 'Last 6 months'}</option>
              <option>{language === 'ar' ? 'آخر سنة' : 'Last year'}</option>
            </select>
          </div>
          <div className="h-64 flex items-center justify-center bg-gray-50 dark:bg-gray-700 rounded-lg">
            <div className="text-center text-gray-500 dark:text-gray-400">
              <TrendingUp className="w-12 h-12 mx-auto mb-2" />
              <p>{language === 'ar' ? 'الرسم البياني سيظهر هنا' : 'Chart will be displayed here'}</p>
            </div>
          </div>
        </div>

        {/* Recent Activities */}
        <div className="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
          <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            {language === 'ar' ? 'الأنشطة الأخيرة' : 'Recent Activities'}
          </h3>
          <div className="space-y-4">
            {recentActivities.map((activity) => (
              <div key={activity.id} className="flex items-start space-x-3 rtl:space-x-reverse">
                <div className={`w-2 h-2 rounded-full mt-2 ${
                  activity.color === 'blue' ? 'bg-blue-500' :
                  activity.color === 'green' ? 'bg-green-500' :
                  'bg-purple-500'
                }`}></div>
                <div className="flex-1 min-w-0">
                  <p className="text-sm text-gray-900 dark:text-white">
                    {activity.message}
                  </p>
                  <p className="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    {activity.time}
                  </p>
                </div>
              </div>
            ))}
          </div>
          <button className="w-full mt-4 text-sm text-primary-600 hover:text-primary-500 font-medium">
            {language === 'ar' ? 'عرض جميع الأنشطة' : 'View all activities'}
          </button>
        </div>
      </div>

      {/* Bottom Row */}
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {/* Upcoming Tasks */}
        <div className="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
          <div className="flex items-center justify-between mb-4">
            <h3 className="text-lg font-semibold text-gray-900 dark:text-white">
              {language === 'ar' ? 'المهام القادمة' : 'Upcoming Tasks'}
            </h3>
            <Calendar className="w-5 h-5 text-gray-400" />
          </div>
          <div className="space-y-3">
            {upcomingTasks.map((task) => (
              <div key={task.id} className="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div className="flex items-center space-x-3 rtl:space-x-reverse">
                  <div className={`w-3 h-3 rounded-full ${
                    task.priority === 'high' ? 'bg-red-500' :
                    task.priority === 'medium' ? 'bg-yellow-500' :
                    'bg-green-500'
                  }`}></div>
                  <div>
                    <p className="text-sm font-medium text-gray-900 dark:text-white">
                      {task.title}
                    </p>
                    <p className="text-xs text-gray-500 dark:text-gray-400">
                      {task.time}
                    </p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>

        {/* Quick Actions */}
        <div className="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
          <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            {language === 'ar' ? 'إجراءات سريعة' : 'Quick Actions'}
          </h3>
          <div className="grid grid-cols-2 gap-4">
            <button className="flex flex-col items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
              <Users className="w-8 h-8 text-blue-600 mb-2" />
              <span className="text-sm font-medium text-blue-600">
                {language === 'ar' ? 'عميل جديد' : 'New Customer'}
              </span>
            </button>
            <button className="flex flex-col items-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
              <MessageSquare className="w-8 h-8 text-green-600 mb-2" />
              <span className="text-sm font-medium text-green-600">
                {language === 'ar' ? 'رسالة جديدة' : 'New Message'}
              </span>
            </button>
            <button className="flex flex-col items-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
              <Activity className="w-8 h-8 text-purple-600 mb-2" />
              <span className="text-sm font-medium text-purple-600">
                {language === 'ar' ? 'إنشاء تقرير' : 'Create Report'}
              </span>
            </button>
            <button className="flex flex-col items-center p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg hover:bg-orange-100 dark:hover:bg-orange-900/30 transition-colors">
              <Calendar className="w-8 h-8 text-orange-600 mb-2" />
              <span className="text-sm font-medium text-orange-600">
                {language === 'ar' ? 'جدولة مهمة' : 'Schedule Task'}
              </span>
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default DashboardPage;